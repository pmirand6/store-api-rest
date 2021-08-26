<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_types".
 *
 * @property int $id
 * @property string $name
 * @property int $active
 *
 * @property Products[] $products
 * @property SubproductTypes[] $subproductTypes
 */
class ProductTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['active'], 'integer'],
            [['name'], 'string', 'max' => 100],
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
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['product_types_id' => 'id']);
    }

    /**
     * Gets query for [[SubproductTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubproductTypes()
    {
        return $this->hasMany(SubproductTypes::className(), ['product_types_id' => 'id']);
    }
}
