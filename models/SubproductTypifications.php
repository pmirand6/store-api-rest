<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subproduct_typifications".
 *
 * @property int $id
 * @property string $name
 * @property int $active
 * @property int $subproduct_types_id
 *
 * @property Products[] $products
 * @property SubproductTypes $subproductTypes
 */
class SubproductTypifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subproduct_typifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'active', 'subproduct_types_id'], 'required'],
            [['active', 'subproduct_types_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['subproduct_types_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubproductTypes::className(), 'targetAttribute' => ['subproduct_types_id' => 'id']],
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
            'subproduct_types_id' => 'Subproduct Types ID',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['subproduct_typifications_id' => 'id']);
    }

    /**
     * Gets query for [[SubproductTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubproductTypes()
    {
        return $this->hasOne(SubproductTypes::className(), ['id' => 'subproduct_types_id']);
    }
}
