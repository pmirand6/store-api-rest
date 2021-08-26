<?php

namespace app\models;

use Yii;
use app\models\tools\SendPushToUserTool;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $email
 * @property string $created_at
 * @property string|null $deleted_at
 * @property string $updated_at
 *
 * @property Providers[] $providers
 * @property Clients[] $clients
 * @property Admin[] $admins
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'email'],
            [['created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['email'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'E-Mail',
            'created_at' => 'Created At',
            'deleted_at' => 'Deleted At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Providers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvider()
    {
        return $this->hasOne(ProvidersSearch::className(), ['users_id' => 'id']);
    }
    
    /**
     * Gets query for [[Clients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['users_id' => 'id']);
    }

    /**
     * Gets query for [[Admins]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne(Admins::className(), ['users_id' => 'id']);
    }

    /**
     * Gets query for [[PushTokens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPushTokens()
    {
        return $this->hasMany(PushTokens::className(), ['users_id' => 'id']);
    }

    public function extraFields()
    {
        return [
            'admin',
            'provider',
            'client',
        ];
    }
    
    public function sendPushNotification(string $title, string $body, array $data): void
    {
        (new SendPushToUserTool($this, $title, $body, $data))->send();
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
