<?php
namespace app\actions\qualifications;

use yii\rest\Action;
use app\helpers\ResponseHelper;
use app\apis\Auth;
use app\models\Purchases;
use app\models\Qualifications;
use Yii;

class SaveQualificationAction extends Action
{
    public $modelClass = 'app\models\Qualifications';

    public function run($code)
    {
        try {
            $purchase = Purchases::findOne([ 'shipping_code' => $code ]);

            if(!($purchase instanceof Purchases)) {
                throw new \Exception('ShippingCode no encontrado');
            }

            $qualification = $purchase->qualification;

            if(!($qualification instanceof Qualifications)) {
                $qualification = new Qualifications();
                $qualification->purchases_id = $purchase->id;
            }
            
            $qualification->load(Yii::$app->getRequest()->getBodyParams(), '');

            if ($this->checkAccess) {
                call_user_func($this->checkAccess, $this->id, $qualification);
            }

            if ($qualification->save() === false && !$qualification->hasErrors()) {
                throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
            }
            
            if($qualification->hasErrors()) {    
                ResponseHelper::run(500);
                return $qualification->getErrors();
            }

            return $qualification;
        } catch (\Throwable $th) {
            ResponseHelper::run(500);
            return [ 'error' => true, 'message'  => $th->getMessage()];
        }
    }
}
