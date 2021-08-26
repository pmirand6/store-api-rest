<?php
namespace app\actions\billingparameters;

use yii\rest\Action;
use app\helpers\ResponseHelper;

class GetBillingParametersAction extends Action
{
    public $modelClass = 'app\models\BillingParameters';

    public function run()
    {
        try {
            $modelClass = $this->modelClass;

            $model = $modelClass::find()->one();

            if ($this->checkAccess) {
                call_user_func($this->checkAccess, $this->id, $model);
            }

            return $model;
        } catch (\Throwable $th) {
            return ResponseHelper::run(500, $th);
        }
    }
}

