<?php

namespace app\models;

use Yii;
use app\apis\Auth;

/**
 * This is the model class for table "products_scored".
 *
 * @property int $id
 * @property string $name
 * @property boolean $new
 * @property string|null $presentation
 * @property string $volumes_name
 * @property float $volume_value
 * @property string $weights_name
 * @property float $weight_value
 * @property int $requires_cold
 * @property float $clasification
 * @property int $stock
 * @property float $price
 * @property int $reposition_point
 * @property int $delivery_time
 * @property int $expires
 * @property int $expires_time
 * @property string $status
 * @property int $active
 * @property string $delivery_types
 * @property string|null $videos
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $created_at
 * @property int|null $subproduct_typifications_id
 * @property int $providers_id
 * @property int $subproduct_types_id
 * @property int $product_types_id
 * @property float|null $score
 * @property float|null $product_score_zero
 * @property float|null $provider_score_zero
 * @property float|null $delivery_score_zero
 * @property float|null $product_score_one
 * @property float|null $provider_score_one
 * @property float|null $delivery_score_one
 * @property float|null $product_score_two
 * @property float|null $provider_score_two
 * @property float|null $delivery_score_two
 * @property float|null $product_score_three
 * @property float|null $provider_score_three
 * @property float|null $delivery_score_three
 * @property float|null $product_score_four
 * @property float|null $provider_score_four
 * @property float|null $delivery_score_four
 * @property float|null $product_score_five
 * @property float|null $provider_score_five
 * @property float|null $delivery_score_five
 * @property int $qualification_count
 * @property float|null $liked
 * @property float|null $disliked
 */
class ProductsScored extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_scored';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'requires_cold', 'stock', 'reposition_point', 'delivery_time', 'expires', 'expires_time', 'active', 'subproduct_typifications_id', 'providers_id', 'subproduct_types_id', 'product_types_id', 'qualification_count'], 'integer'],
            [['name', 'volumes_name', 'volume_value', 'weights_name', 'weight_value', 'stock', 'price', 'reposition_point', 'expires', 'expires_time', 'active', 'delivery_types', 'providers_id', 'subproduct_types_id', 'product_types_id'], 'required'],
            [['presentation', 'status', 'delivery_types', 'videos'], 'string'],
            [['volume_value', 'weight_value', 'clasification', 'price', 'score', 'product_score_zero', 'provider_score_zero', 'delivery_score_zero', 'product_score_one', 'provider_score_one', 'delivery_score_one', 'product_score_two', 'provider_score_two', 'delivery_score_two', 'product_score_three', 'provider_score_three', 'delivery_score_three', 'product_score_four', 'provider_score_four', 'delivery_score_four', 'product_score_five', 'provider_score_five', 'delivery_score_five', 'liked', 'disliked'], 'number'],
            [['updated_at', 'deleted_at', 'created_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['new'], 'boolean'],
            [['volumes_name', 'weights_name'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc$primaryKey
     */
    public static function primaryKey()
    {
        return ["id"];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'presentation' => 'Presentation',
            'volumes_name' => 'Volumes Name',
            'volume_value' => 'Volume Value',
            'weights_name' => 'Weights Name',
            'weight_value' => 'Weight Value',
            'requires_cold' => 'Requires Cold',
            'clasification' => 'Clasification',
            'stock' => 'Stock',
            'price' => 'Price',
            'reposition_point' => 'Reposition Point',
            'delivery_time' => 'Delivery Time',
            'expires' => 'Expires',
            'expires_time' => 'Expires Time',
            'status' => 'Status',
            'active' => 'Active',
            'delivery_types' => 'Delivery Types',
            'videos' => 'Videos',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'created_at' => 'Created At',
            'subproduct_typifications_id' => 'Subproduct Typifications ID',
            'providers_id' => 'Providers ID',
            'subproduct_types_id' => 'Subproduct Types ID',
            'product_types_id' => 'Product Types ID',
            'score' => 'Score',
            'product_score_zero' => 'Product Score Zero',
            'provider_score_zero' => 'Provider Score Zero',
            'delivery_score_zero' => 'Delivery Score Zero',
            'product_score_one' => 'Product Score One',
            'provider_score_one' => 'Provider Score One',
            'delivery_score_one' => 'Delivery Score One',
            'product_score_two' => 'Product Score Two',
            'provider_score_two' => 'Provider Score Two',
            'delivery_score_two' => 'Delivery Score Two',
            'product_score_three' => 'Product Score Three',
            'provider_score_three' => 'Provider Score Three',
            'delivery_score_three' => 'Delivery Score Three',
            'product_score_four' => 'Product Score Four',
            'provider_score_four' => 'Provider Score Four',
            'delivery_score_four' => 'Delivery Score Four',
            'product_score_five' => 'Product Score Five',
            'provider_score_five' => 'Provider Score Five',
            'delivery_score_five' => 'Delivery Score Five',
            'qualification_count' => 'Qualification Count',
            'liked' => 'Liked',
            'disliked' => 'Disliked',
            'new' => 'New'
        ];
    }

    /**
     * Gets query for [[ProductImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImages::className(), ['products_id' => 'id']);
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
     * Gets query for [[Providers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProviders()
    {
        return $this->hasOne(ProvidersSearch::className(), ['id' => 'providers_id']);
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

    /**
     * Gets query for [[SubproductTypifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubproductTypifications()
    {
        return $this->hasOne(SubproductTypifications::className(), ['id' => 'subproduct_typifications_id']);
    }

    /**
     * Gets query for [[ProductsHasDeliveryTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductsHasDeliveryTypes()
    {
        return $this->hasMany(ProductsHasDeliveryTypes::className(), ['products_id' => 'id']);
    }

    public function extraFields()
    {
        return [
            'productTypes',
            'subproductTypes',
            'providers',
            'subproductTypifications',
            'productImages', 
            'favorites',
            'productsHasDeliveryTypes'
        ];
    }

    public function getFavorites()
    {
        $user = Auth::instance()->getUser(true);
        $client_id = null;

        if($user && $user->client instanceof Clients) {
            $client_id = $user->client->id;
            $where['favorites.clients_id'] = $client_id;
            $where['favorites.deleted_at'] = null;

            return $this->hasOne(Favorites::className(), [
                'products_id' => 'id'
            ])->onCondition($where);
        } else {
            return $this->hasOne(Favorites::className(), [
                'products_id' => 'id',
            ])->onCondition('1=0');
        }
        
    }

    /**
     * Gets query for [[ViewsHistory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getViewsHistory()
    {
        return $this->hasMany(ViewsHistory::className(), ['products_id' => 'id']);
    }

}
