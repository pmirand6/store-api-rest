<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "qualification_votes".
 *
 * @property int $id
 * @property int $qualifications_id
 * @property int $clients_id
 * @property int|null $liked
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $created_at
 *
 * @property Clients $clients
 * @property Qualifications $qualifications
 */
class QualificationVotes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qualification_votes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['qualifications_id', 'clients_id'], 'required'],
            [['liked'], 'boolean'],
            [['qualifications_id', 'clients_id'], 'integer'],
            [['updated_at', 'deleted_at', 'created_at'], 'safe'],
            [['clients_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['clients_id' => 'id']],
            [['qualifications_id'], 'exist', 'skipOnError' => true, 'targetClass' => Qualifications::className(), 'targetAttribute' => ['qualifications_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'qualifications_id' => 'Qualifications ID',
            'clients_id' => 'Clients ID',
            'liked' => 'Liked',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Clients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasOne(Clients::className(), ['id' => 'clients_id']);
    }

    /**
     * Gets query for [[Qualifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQualifications()
    {
        return $this->hasOne(Qualifications::className(), ['id' => 'qualifications_id']);
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
