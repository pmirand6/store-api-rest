<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_has_interest_groups".
 *
 * @property int $id
 * @property int $clients_id
 * @property int $product_types_id
 *
 * @property Clients $clients
 * @property ProductTypes $productTypes
 */
class ClientHasInterestGroups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_has_interest_groups';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clients_id', 'product_types_id'], 'required'],
            [['clients_id', 'product_types_id'], 'integer'],
            [['clients_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['clients_id' => 'id']],
            [['product_types_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductTypes::className(), 'targetAttribute' => ['product_types_id' => 'id']],
        ];
    }

    public function extraFields()
    {
        return [
            'productType',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'clients_id' => 'Clients ID',
            'product_types_id' => 'Product Types ID',
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
     * Gets query for [[ProductTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductType()
    {
        return $this->hasOne(ProductTypes::className(), ['id' => 'product_types_id']);
    }
}
