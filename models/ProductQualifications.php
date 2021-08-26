<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_qualifications".
 *
 * @property int $id
 * @property int $quantity
 * @property float|null $product_score
 * @property float|null $delivery_score
 * @property float|null $provider_score
 * @property float|null $liked
 * @property float|null $disliked
 */
class ProductQualifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_qualifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'quantity'], 'integer'],
            [['product_score', 'delivery_score', 'provider_score', 'liked', 'disliked'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quantity' => 'Quantity',
            'product_score' => 'Product Score',
            'delivery_score' => 'Delivery Score',
            'provider_score' => 'Provider Score',
            'liked' => 'Liked',
            'disliked' => 'Disliked',
        ];
    }
}
