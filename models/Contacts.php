<?php

namespace app\models;

use Yii;
use app\models\Config;

/**
 * This is the model class for table "contacts".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $message
 * @property string $email
 */
class Contacts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['email'], 'required'],
            [['email'], 'email'],
            [['title', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'message' => 'Message',
            'email' => 'Email',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($insert) {
            $config = Config::find()->one();
            $emailTo = $config instanceof Config ? $config->contact_email : 'info@feriame.com';
            
            Yii::$app->mailer->compose('contacts/contact', [
                'contact' => $this,
            ])
            ->setFrom('info@feriame.com')
            ->setTo($emailTo)
            ->setSubject('Feriame.com | Nuevo contacto')
            ->send();
        }
    }
}
