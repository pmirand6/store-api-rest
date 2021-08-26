<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "search_logs".
 *
 * @property int $id
 * @property string|null $query
 * @property int|null $users_id
 *
 * @property Users $users
 */
class SearchLogs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'search_logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['query'], 'string'],
            [['users_id'], 'integer'],
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
            'query' => 'Query',
            'users_id' => 'Users ID',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }

    public static function create($params): void
    {
        $log = new self;
        $log->query = http_build_query($params);
        $log->save();
    }
}
