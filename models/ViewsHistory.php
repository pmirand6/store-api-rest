<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "views_history".
 *
 * @property int $id
 * @property int $products_id
 * @property int $clients_id
 * @property string $date
 *
 * @property Clients $clients
 * @property Products $products
 */
class ViewsHistory extends \yii\db\ActiveRecord
{
    public $product_type;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'views_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['products_id', 'clients_id'], 'required'],
            [['products_id', 'clients_id'], 'integer'],
            [['date'], 'safe'],
            [['clients_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['clients_id' => 'id']],
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
            'clients_id' => 'Clients ID',
            'date' => 'Date',
        ];
    }

    /**
     * Gets query for [[Clients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasOne(Clients::className(), ['id' => 'clients_id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(ProductsScored::className(), ['id' => 'products_id']);
    }

    public function extraFields()
    {
        return ['product'];
    }
}
