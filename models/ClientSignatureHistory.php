<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_signature_history".
 *
 * @property int $id
 * @property int $clients_id
 * @property string $date
 * @property string|null $ip
 * @property string|null $user_agent
 *
 * @property Clients $clients
 */
class ClientSignatureHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_signature_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clients_id'], 'required'],
            [['clients_id'], 'integer'],
            [['date'], 'safe'],
            [['user_agent'], 'string'],
            [['ip'], 'string', 'max' => 100],
            [['clients_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['clients_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'clients_id' => 'Clients ID',
            'date' => 'Date',
            'ip' => 'Ip',
            'user_agent' => 'User Agent',
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
}
