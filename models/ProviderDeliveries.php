<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provider_deliveries".
 *
 * @property int $id
 * @property string $time_from
 * @property string $time_to
 * @property string $day
 * @property int $providers_id
 *
 * @property Providers $providers
 */
class ProviderDeliveries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'provider_deliveries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['time_from', 'time_to', 'day', 'providers_id'], 'required'],
            [['time_from', 'time_to'], 'safe'],
            [['day'], 'string'],
            [['providers_id'], 'integer'],
            [['providers_id'], 'exist', 'skipOnError' => true, 'targetClass' => Providers::className(), 'targetAttribute' => ['providers_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time_from' => 'Time From',
            'time_to' => 'Time To',
            'day' => 'Day',
            'providers_id' => 'Providers ID',
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
