<?php 
namespace app\controllers;

use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use app\apis\Auth;
use app\models\Users;
use app\models\Admins;
use app\models\Providers;
use app\models\Clients;

class PurchaseordersController extends BaseController
{
    public $modelClass = 'app\models\PurchaseOrders';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index', 'view', 'create', 'update', 'delete', 'client'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['create', 'index'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        return $this->authMiddleware($rule, $action);
                    }
                ],
                [
                    'allow' => true,
                    'actions' => ['index', 'view', 'update', 'delete', 'client'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        return false;
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

        $actions['create'] = [
            'class' => 'app\actions\purchaseorders\CreatePurchaseOrderAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['index'] = [
            'class' => 'app\actions\IndexAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'prepareDataProvider' => [$this, 'prepareDataProvider'],
        ];

        return $actions;
    }
    
    public function prepareDataProvider() 
    {
        $searchModel = new \app\models\PurchaseOrdersSearch();

        $user = Auth::instance()->getUser();
        $client_id = null;

        if($user && $user->client instanceof Clients) {
            $client_id = $user->client->id;
        }
        
        $params =  \Yii::$app->request->queryParams;
        $params['filter']['purchases.clients_id'] = $client_id;
        
        return $searchModel->search($params);
    }

    public function checkAccess($action, $model = NULL, $params = []) {
        if(!($this->user instanceof Users)) {
            throw new \Exception("No está registrado");
        }

        if($this->user->admin instanceof Admins) {
            return true;
        }

        if(!($this->user->client instanceof Clients)) {
            throw new \Exception("No tiene permisos");
        }

        if($model instanceof PurchasesOrders && $model->clients_id !== $this->user->client->id) {
            throw new \Exception("Esta entidad no le pertenece");
        }
    }
}