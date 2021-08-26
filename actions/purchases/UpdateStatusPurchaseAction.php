<?php
namespace app\actions\purchases;

use yii\rest\Action;
use app\helpers\ResponseHelper;
use app\apis\Auth;
use app\models\Purchases;
use Yii;

class UpdateStatusPurchaseAction extends Action
{
    public $modelClass = 'app\models\Purchases';

    public function run($code)
    {
        try {
            $purchase = Purchases::findOne([ 'shipping_code' => $code ]);

            if(!($purchase instanceof Purchases)) {
                throw new \Exception('Compra no encontrada');
            }

            $bodyParams = Yii::$app->getRequest()->getBodyParams();

            $purchase->load([ 
                'shipping_status' => $bodyParams['shipping_status'],
                'shipping_status_code' => $bodyParams['shipping_status_code']
            ], '');

            if ($this->checkAccess) {
                call_user_func($this->checkAccess, $this->id, $purchase);
            }

            if ($purchase->save() === false && !$purchase->hasErrors()) {
                throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
            }
            
            if($purchase->hasErrors()) {    
                ResponseHelper::run(500);
                return ['error' => true, 'message' => $purchase->getErrors()];
            }

            return $purchase;
        } catch (\Throwable $th) {
            ResponseHelper::run(500);
            return [ 'error' => true, 'message'  => $th->getMessage()];
        }
    }
}
