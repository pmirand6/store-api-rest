<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provider_statuses".
 *
 * @property int $id
 * @property string $status
 * @property int $providers_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Providers $providers
 */
class ProviderStatuses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'provider_statuses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'providers_id'], 'required'],
            [['status'], 'string'],
            [['providers_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['providers_id'], 'exist', 'skipOnError' => true, 'targetClass' => Providers::className(), 'targetAttribute' => ['providers_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status' => Yii::t('app', 'Status'),
            'providers_id' => Yii::t('app', 'Providers ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Providers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProviders()
    {
        return $this->hasOne(Providers::className(), ['id' => 'providers_id']);
    }
}
