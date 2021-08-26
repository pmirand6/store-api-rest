<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provider_contacts".
 *
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $dni
 * @property string $birthday_date
 * @property int $responsable
 * @property string $email
 * @property float $phone_number
 * @property int $providers_id
 * @property string $created_at
 * @property string|null $deleted_at
 * @property string $updated_at
 *
 * @property Providers $providers
 */
class ProviderContacts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'provider_contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'dni', 'birthday_date', 'responsable', 'email', 'phone_number', 'providers_id'], 'required'],
            [['birthday_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['providers_id'], 'integer'],
            [['responsable'], 'boolean'],
            [['phone_number'], 'number'],
            [['firstname', 'lastname', 'email'], 'string', 'max' => 50],
            [['dni'], 'string', 'max' => 20],
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
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'dni' => 'Dni',
            'birthday_date' => 'Birthday Date',
            'responsable' => 'Responsable',
            'email' => 'Email',
            'phone_number' => 'Phone Number',
            'providers_id' => 'Providers ID',
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
    public function getProviders()
    {
        return $this->hasOne(Providers::className(), ['id' => 'providers_id']);
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
