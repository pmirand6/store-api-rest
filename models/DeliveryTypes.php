<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "delivery_types".
 *
 * @property int $id
 * @property string $delivery_type
 *
 * @property Purchases[] $purchases
 */
class DeliveryTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'delivery_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['delivery_type'], 'required'],
            [['delivery_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'delivery_type' => 'Delivery Type',
        ];
    }

    /**
     * Gets query for [[Purchases]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPurchases()
    {
        return $this->hasMany(Purchases::className(), ['delivery_types_id' => 'id']);
    }
}
