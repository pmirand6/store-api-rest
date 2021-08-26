<?php
namespace app\actions\products;

use yii\rest\Action;
use app\helpers\ResponseHelper;
use app\apis\Auth;
use app\models\ProductsHasDeliveryTypes;
use Yii;

class SaveProductsDeliveryTypesAction extends Action
{
    public $modelClass = 'app\models\Products';

    public function run($id)
    {
        try {
            $product = $this->findModel($id);

            if(!$product) {
                throw new \Exception('Este producto no existe');
            }

            if ($this->checkAccess) {
                call_user_func($this->checkAccess, $this->id, $product);
            }

            // Delete ProductsHasDeliveryTypes
            foreach ($product->productsHasDeliveryTypes as $deliveryType) {
                $deliveryType->delete();
            }

            $deliveryTypesId = Yii::$app->getRequest()->getBodyParams();

            if(!is_array($deliveryTypesId)) {
                throw new Exception('Ingrese un array de delivery_types_id');
            }

            $response = [];
            // Save ProductsHasDeliveryTypes
            foreach ($deliveryTypesId as $deliveryTypeId) {
                $productHasDeliveryType = new ProductsHasDeliveryTypes();
                $productHasDeliveryType->products_id = $product->id;
                $productHasDeliveryType->delivery_types_id = $deliveryTypeId;
                
                if($productHasDeliveryType->save()) {
                    $response[] = $productHasDeliveryType->getAttributes();
                } else {
                    $response[] = $productHasDeliveryType->getErrors();
                }
            }

            return $response;
        } catch (\Throwable $th) {
            var_dump($th);die;
            return ResponseHelper::run(500, $th);
        }
    }
}
