<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subproduct_types".
 *
 * @property int $id
 * @property string $name
 * @property int $active
 * @property int $product_types_id
 *
 * @property Products[] $products
 * @property ProductTypes $productTypes
 * @property SubproductTypifications[] $subproductTypifications
 */
class SubproductTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subproduct_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'active', 'product_types_id'], 'required'],
            [['active', 'product_types_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['product_types_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductTypes::className(), 'targetAttribute' => ['product_types_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'active' => 'Active',
            'product_types_id' => 'Product Types ID',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['subproduct_types_id' => 'id']);
    }

    /**
     * Gets query for [[ProductTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductTypes()
    {
        return $this->hasOne(ProductTypes::className(), ['id' => 'product_types_id']);
    }

    /**
     * Gets query for [[SubproductTypifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubproductTypifications()
    {
        return $this->hasMany(SubproductTypifications::className(), ['subproduct_types_id' => 'id']);
    }
}
