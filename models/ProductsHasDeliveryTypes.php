<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products_has_delivery_types".
 *
 * @property int $id
 * @property int $products_id
 * @property int $delivery_types_id
 *
 * @property DeliveryTypes $deliveryTypes
 * @property Products $products
 */
class ProductsHasDeliveryTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_has_delivery_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['products_id', 'delivery_types_id'], 'required'],
            [['products_id', 'delivery_types_id'], 'integer'],
            [['delivery_types_id'], 'exist', 'skipOnError' => true, 'targetClass' => DeliveryTypes::className(), 'targetAttribute' => ['delivery_types_id' => 'id']],
            [['products_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['products_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'products_id' => 'Products ID',
            'delivery_types_id' => 'Delivery Types ID',
        ];
    }

    /**
     * Gets query for [[DeliveryTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveryType()
    {
        return $this->hasOne(DeliveryTypes::className(), ['id' => 'delivery_types_id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasOne(Products::className(), ['id' => 'products_id']);
    }
    public function extraFields()
    {
        return [
            'deliveryType',
        ];
    }
}
