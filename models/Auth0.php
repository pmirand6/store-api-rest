<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "auth0".
 *
 * @property int $id
 * @property int $users_id
 * @property string $sub
 *
 * @property Users $users
 */
class Auth0 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth0';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['users_id', 'sub'], 'required'],
            [['users_id'], 'integer'],
            [['sub'], 'string', 'max' => 100],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['users_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'users_id' => 'Users ID',
            'sub' => 'Sub',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }
}
