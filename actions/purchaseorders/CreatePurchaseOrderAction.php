<?php
namespace app\actions\purchaseorders;

use Carbon\Carbon;
use Yii;
use yii\rest\Action;
use app\helpers\ResponseHelper;
use app\apis\Auth;
use app\models\Purchases;

class CreatePurchaseOrderAction extends Action
{
    public $modelClass = 'app\models\PurchaseOrders';

    public function run()
    {
        try {
            $model = new $this->modelClass();

            if(!$model->save()) {
                throw new Exception(json_encode($model->getErrors()));
            }

            if ($this->checkAccess) {
                call_user_func($this->checkAccess, $this->id, $model);
            }

            $purchases = Yii::$app->getRequest()->getBodyParams();

            if(isset($purchases['purchases']) && !is_array($purchases['purchases'])) {
                throw new Exception('Ingrese un array de purchases');
            }

            $response = [];
            // Save ClientHasInterestGroups
            foreach ($purchases['purchases'] as $purchaseRequest) {
                $purchase = new Purchases();
                $purchase->load($purchaseRequest, '');
                $purchase->purchase_orders_id = $model->id;
                $purchase->estimated_delivery_date = Carbon::createFromFormat('d/m/Y', $purchaseRequest['estimated_delivery_date'])->format('Y-m-d H:i:s');

                // Calcular delivery cost
                $deliveryCost = $purchase->deliveryType->delivery_type === 'delivery' ? $purchase->product->getDeliverCost($purchase->addresses_id, $purchase->quantity)['gross_price'] : 0;
                $purchase->delivery_cost = $deliveryCost;

                if($purchase->save()) {
                    $response[] = $purchase->getAttributes();
                } else {
                    $response[] = $purchase->getErrors();
                }
            }

            return $model->getAttributes();
        } catch (\Throwable $th) {
            Yii::error($th->getMessage(), 'purchase');
            ResponseHelper::run(500);
            return ['error' => true, 'message' => $th->getMessage()];
        }
    }
}
