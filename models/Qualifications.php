<?php

namespace app\models;

use Yii;
use app\apis\Auth;

/**
 * This is the model class for table "qualifications".
 *
 * @property int $id
 * @property int $purchases_id
 * @property int|null $liked
 * @property int|null $product_score
 * @property int|null $delivery_score
 * @property int|null $provider_score
 * @property string|null $title
 * @property string|null $comment
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $created_at
 *
 * @property Purchases $purchases
 */
class Qualifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qualifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['purchases_id'], 'required'],
            [['liked'], 'boolean'],
            [['title'], 'string', 'max' => 255],
            [['purchases_id', 'product_score', 'delivery_score', 'provider_score'], 'integer'],
            [['updated_at', 'deleted_at', 'created_at', 'comment', 'title'], 'safe'],
            [['purchases_id'], 'exist', 'skipOnError' => true, 'targetClass' => Purchases::className(), 'targetAttribute' => ['purchases_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'purchases_id' => 'Purchases ID',
            'liked' => 'Liked',
            'product_score' => 'Product Score',
            'delivery_score' => 'Delivery Score',
            'provider_score' => 'Provider Score',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'created_at' => 'Created At',
            'comment' => 'Comment',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[Purchases]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPurchase()
    {
        return $this->hasOne(Purchases::className(), ['id' => 'purchases_id']);
    }

    public function getQualificationVote()
    {
        $user = Auth::instance()->getUser(true);
        $client_id = null;

        if($user && $user->client instanceof Clients) {
            $client_id = $user->client->id;
            $where['qualification_votes.clients_id'] = $client_id;

            return $this->hasOne(QualificationVotes::className(), [
                'qualifications_id' => 'id'
            ])->onCondition($where);
        } else {
            return $this->hasOne(QualificationVotes::className(), [
                'qualifications_id' => 'id',
            ])->onCondition('1=0');
        }
        
    }

    public function extraFields()
    {
        return [ 'qualificationVote' ];
    }
    
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        
        // Update date
        if(!$insert) {
            $this->updated_at = date('Y-m-d H:i:s', strtotime('NOW'));
        }

        return parent::beforeSave($insert);
    }
}
