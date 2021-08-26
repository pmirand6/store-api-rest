<?php
namespace app\actions\products;

use yii\rest\ViewAction;
use app\helpers\ResponseHelper;
use app\apis\Auth;
use app\models\ViewsHistory;
use app\models\ProductsScored;
use app\models\ProductsScoredZero;
use app\models\ProductsScoredOne;
use app\models\ProductsScoredTwo;
use app\models\ProductsScoredThree;
use app\models\ProductsScoredFour;
use app\models\ProductsScoredFive;

class ViewTotalProductsScoredAction extends ViewAction
{
    public $modelClass = 'app\models\ProductsScored';

    public function run($id)
    {
        $result = null;
        try {
            $productsScored = ProductsScored::find()->where(['id' => $id])->one();
            if(!($productsScored instanceof ProductsScored)) {
                return $result;
            }

            $result['total'] = $productsScored->qualification_count;
            $result['total_score'] = $productsScored->score;
            $result['values'] = [];
            
            $productsScoredZero = ProductsScoredZero::find()->where(['id' => $id])->one();
            $result['values'][] = [
                "startNumber" => 0,
                "countStarts" => $productsScoredZero instanceof ProductsScoredZero ? $productsScoredZero->qualification_count : 0,
                "productScoreQuantity" => $productsScoredZero instanceof ProductsScoredZero ? $productsScoredZero->product_score : 0,
                "providerScoreQuantity" => $productsScoredZero instanceof ProductsScoredZero ? $productsScoredZero->provider_score : 0,
                "deliveryScoreQuantity" => $productsScoredZero instanceof ProductsScoredZero ? $productsScoredZero->delivery_score : 0,
            ];

            
            $productsScoredOne = ProductsScoredOne::find()->where(['id' => $id])->one();
            $result['values'][] = [
                "startNumber" => 1,
                "countStarts" => $productsScoredOne instanceof ProductsScoredOne ? $productsScoredOne->qualification_count : 0,
                "productScoreQuantity" => $productsScoredOne instanceof ProductsScoredOne ? $productsScoredOne->product_score : 0,
                "providerScoreQuantity" => $productsScoredOne instanceof ProductsScoredOne ? $productsScoredOne->provider_score : 0,
                "deliveryScoreQuantity" => $productsScoredOne instanceof ProductsScoredOne ? $productsScoredOne->delivery_score : 0,
            ];

            $productsScoredTwo = ProductsScoredTwo::find()->where(['id' => $id])->one();
            $result['values'][] = [
                "startNumber" => 2,
                "countStarts" => $productsScoredTwo instanceof ProductsScoredTwo ? $productsScoredTwo->qualification_count : 0,
                "productScoreQuantity" => $productsScoredTwo instanceof ProductsScoredTwo ? $productsScoredTwo->product_score : 0,
                "providerScoreQuantity" => $productsScoredTwo instanceof ProductsScoredTwo ? $productsScoredTwo->provider_score : 0,
                "deliveryScoreQuantity" => $productsScoredTwo instanceof ProductsScoredTwo ? $productsScoredTwo->delivery_score : 0,
            ];
            
            $productsScoredThree = ProductsScoredThree::find()->where(['id' => $id])->one();
            $result['values'][] = [
                "startNumber" => 3,
                "countStarts" => $productsScoredThree instanceof ProductsScoredThree ? $productsScoredThree->qualification_count : 0,
                "productScoreQuantity" => $productsScoredThree instanceof ProductsScoredThree ? $productsScoredThree->product_score : 0,
                "providerScoreQuantity" => $productsScoredThree instanceof ProductsScoredThree ? $productsScoredThree->provider_score : 0,
                "deliveryScoreQuantity" => $productsScoredThree instanceof ProductsScoredThree ? $productsScoredThree->delivery_score : 0,
            ];

            $productsScoredFour = ProductsScoredFour::find()->where(['id' => $id])->one();
            $result['values'][] = [
                "startNumber" => 4,
                "countStarts" => $productsScoredFour instanceof ProductsScoredFour ? $productsScoredFour->qualification_count : 0,
                "productScoreQuantity" => $productsScoredFour instanceof ProductsScoredFour ? $productsScoredFour->product_score : 0,
                "providerScoreQuantity" => $productsScoredFour instanceof ProductsScoredFour ? $productsScoredFour->provider_score : 0,
                "deliveryScoreQuantity" => $productsScoredFour instanceof ProductsScoredFour ? $productsScoredFour->delivery_score : 0,
            ];
            
            $productsScoredFive = ProductsScoredFive::find()->where(['id' => $id])->one();
            $result['values'][] = [
                "startNumber" => 5,
                "countStarts" => $productsScoredFive instanceof ProductsScoredFive ? $productsScoredFive->qualification_count : 0,
                "productScoreQuantity" => $productsScoredFive instanceof ProductsScoredFive ? $productsScoredFive->product_score : 0,
                "providerScoreQuantity" => $productsScoredFive instanceof ProductsScoredFive ? $productsScoredFive->provider_score : 0,
                "deliveryScoreQuantity" => $productsScoredFive instanceof ProductsScoredFive ? $productsScoredFive->delivery_score : 0,
            ];
        } catch (\Throwable $th) {
            ResponseHelper::run(500);
            return [ 'error' => true, 'message' => $th->getMessage() ];
        }

        return [ 'error' => false, 'data' => $result ];
    }
}
