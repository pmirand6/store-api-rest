<?php
namespace app\actions\billingparameters;

use Yii;
use yii\rest\Action;
use yii\web\ServerErrorHttpException;
use app\apis\Auth;
use app\models\BillingParameters;
use app\helpers\ResponseHelper;

class ConfigureBillingParametersAction extends Action
{
    public function run()
    {
        try {
            $model = BillingParameters::find()->one();
            
            if ($this->checkAccess) {
                call_user_func($this->checkAccess, $this->id, $model);
            }

            if(!$model) {
                $model = new BillingParameters();
            }

            $model->load(Yii::$app->getRequest()->getBodyParams(), '');
    
            if ($model->save() === false) {
                ResponseHelper::run(500);
                return $model->getErrors();
            }
            
            return $model;

        } catch (\Throwable $th) {
            ResponseHelper::run(500);
            return $th->getMessage();
        }
    }
}
