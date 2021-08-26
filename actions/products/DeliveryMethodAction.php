<?php
namespace app\actions\products;

use Yii;
use yii\rest\Action;
use app\helpers\ResponseHelper;
use app\apis\Auth;
use app\models\Addresses;
use app\models\Providers;
use app\models\Clients;
use app\models\Products;
use app\models\ProductsHasDeliveryTypes;
use app\models\BillingParameters;
use GuzzleHttp\Client;

class DeliveryMethodAction extends Action
{

    public $modelClass = 'app\models\Products';

    public function run($id,$addressesId,$quantity=null)
    {
        try {
            $product = Products::findOne(['id' => $id]);
            if (!($product instanceof Products)) {
                throw new Exception('Producto no encontrado.');
            }

            return ['data' => $product->getDeliveryInfo($addressesId, $quantity)];
        } catch (\Throwable $th) {
            ResponseHelper::run(500);
            return ['error' => true, 'message' => $th->getMessage()];
        }
    }
}
