<?php 
namespace app\controllers;

use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use app\apis\Auth;
use app\models\Contracts;

class ContractsController extends BaseController
{
    public $modelClass = 'app\models\Contracts';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => [ 'index',  'view',  'create',  'update',  'delete', 'client', 'provider' ],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => [ 'index',  'view',  'create',  'update',  'delete' ],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        return $this->authMiddleware($rule, $action);
                    }
                ],
                [
                    'allow' => true,
                    'actions' => [ 'client', 'provider' ],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        return true;
                    }
                ]
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
        
        $actions['delete'] = [
            'class' => 'app\actions\SoftDeleteAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        
        $actions['client'] = [
            'class' => 'app\actions\contracts\GetLastContractAction',
            'modelClass' => $this->modelClass,
            'type' => Contracts::TYPE_CLIENT,
        ];
        
        $actions['provider'] = [
            'class' => 'app\actions\contracts\GetLastContractAction',
            'modelClass' => $this->modelClass,
            'type' => Contracts::TYPE_PROVIDER,
        ];

        return $actions;
    }
}