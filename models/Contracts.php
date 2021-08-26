<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contracts".
 *
 * @property int $id
 * @property int $type
 * @property string $contract
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $created_at
 */
class Contracts extends SoftDeleteModel
{
    public const TYPE_PROVIDER = 1;
    public const TYPE_CLIENT = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contracts';
    }

    public static function types(): array
    {
        return [
            'TYPE_PROVIDER' => self::TYPE_PROVIDER,
            'TYPE_CLIENT' => self::TYPE_CLIENT,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'contract'], 'required'],
            [['type'], 'integer'],
            [['contract'], 'string'],
            [['updated_at', 'deleted_at', 'created_at'], 'safe'],
            ['type', function ($attribute, $params, $validator) {
                if (!in_array($this->$attribute, array_values( self::types() ))) {
                    $this->addError($attribute, 'Type can be TYPE_PROVIDER: 1 or TYPE_CLIENT: 2.');
                }
            }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'contract' => 'Contract',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'created_at' => 'Created At',
        ];
    }

    public static function getLastContract(int $type)
    {
        return Contracts::find()
            ->where(['deleted_at' => null])
            ->andWhere(['type' => $type])
            ->orderBy(['created_at' => SORT_DESC])
            ->one();
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
