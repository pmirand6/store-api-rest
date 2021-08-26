<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provider_signature_history".
 *
 * @property int $id
 * @property int $providers_id
 * @property string $date
 * @property string|null $ip
 * @property string|null $user_agent
 *
 * @property Providers $providers
 */
class ProviderSignatureHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'provider_signature_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['providers_id'], 'required'],
            [['providers_id'], 'integer'],
            [['date'], 'safe'],
            [['user_agent'], 'string'],
            [['ip'], 'string', 'max' => 100],
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
            'providers_id' => 'Providers ID',
            'date' => 'Date',
            'ip' => 'Ip',
            'user_agent' => 'User Agent',
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
