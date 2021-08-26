<?php 
namespace app\controllers;

use app\models\Admins;
use app\models\Users;
use app\models\BillingParameters;
use app\controllers\BaseController;
use yii\filters\AccessControl;
use app\apis\Auth;
use yii\helpers\ArrayHelper;

class BillingparametersController extends BaseController
{
    public $modelClass = 'app\models\BillingParameters';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index', 'configure'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index', 'configure'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        return $this->authMiddleware($rule, $action);
                    }
                ],
            ],
            'denyCallback' => function($rule, $action){
                throw new \yii\web\ForbiddenHttpException('You are not allowed to perform this action.');
            } 
        ];

        return $behaviors;
    }

    public function actions() 
    { 
        $actions = parent::actions();

        $actions['configure'] = [
            'class' => 'app\actions\billingparameters\ConfigureBillingParametersAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['index'] = [
            'class' => 'app\actions\billingparameters\GetBillingParametersAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        return $actions;
    }

    public function checkAccess($action, $model = NULL, $params = []) {
        if(!($this->user instanceof Users)) {
            throw new \Exception("No está registrado");
        }

        if(!($this->user->admin instanceof Admins)) {
            throw new \Exception("No está registrado como admin");
        }
    }
}