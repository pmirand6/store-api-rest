<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "favorites_log".
 *
 * @property int $log_id
 * @property int $id
 * @property int $clients_id
 * @property int $products_id
 * @property string $created_at
 * @property string|null $deleted_at
 * @property string $updated_at
 *
 * @property Favorites $id0
 */
class FavoritesLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favorites_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'clients_id', 'products_id'], 'required'],
            [['id', 'clients_id', 'products_id'], 'integer'],
            [['created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Favorites::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'log_id' => 'Log ID',
            'id' => 'ID',
            'clients_id' => 'Clients ID',
            'products_id' => 'Products ID',
            'created_at' => 'Created At',
            'deleted_at' => 'Deleted At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(Favorites::className(), ['id' => 'id']);
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
