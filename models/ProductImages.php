<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_images".
 *
 * @property int $id
 * @property string $image
 * @property int $products_id
 *
 * @property Products $products
 */
class ProductImages extends \yii\db\ActiveRecord
{
    public $path = "../web/uploads/product/";
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['products_id'], 'required'],
            [['image'], 'string'],
            [['products_id'], 'integer'],
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
            'image' => 'Image',
            'products_id' => 'Products ID',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'products_id']);
    }
    
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        try{
            if(isset($_FILES['image'])){
                if (!file_exists($this->path .$this->products_id)) {
                    mkdir($this->path .$this->products_id, 0777, true);
                }

                $path = $this->path .$this->products_id."/". basename( $_FILES['image']['name'].rand());                
                move_uploaded_file($_FILES['image']['tmp_name'], $path);

                $this->image = $path;
            }

            return parent::beforeSave($insert); // TODO: Change the autogenerated stub
        }
        catch(Exeption $e)
        {
            throw new \yii\web\NotFoundHttpException;
        }
    }
}
