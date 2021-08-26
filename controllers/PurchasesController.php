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
use app\models\Purchases;

class PurchasesController extends BaseController
{
    public $modelClass = 'app\models\Purchases';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index', 'view', 'create', 'update', 'delete', 'client'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['create', 'client'],
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

        $actions['delete']['class'] = 'app\actions\SoftDeleteAction';

        $actions['updatestatus'] = [
            'class' => 'app\actions\purchases\UpdateStatusPurchaseAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccessStatus'],
        ];

        $actions['client'] = [
            'class' => 'app\actions\IndexAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'prepareDataProvider' => [$this, 'prepareDataProvider'],
        ];

        return $actions;
    }
    public function prepareDataProvider() 
    {
        $searchModel = new \app\models\PurchasesSearch();

        $user = Auth::instance()->getUser();
        $client_id = null;

        if($user && $user->client instanceof Clients) {
            $client_id = $user->client->id;
        }
        
        $params =  \Yii::$app->request->queryParams;
        $params['filter']['clients_id'] = $client_id;
        
        return $searchModel->search($params);
    }

    public function checkAccess($action, $model = NULL, $params = []) {
        if(!($this->user instanceof Users)) {
            throw new \Exception("No está registrado");
        }

        if($this->user->admin instanceof Admins) {
            return true;
        }

        if(!($this->user->client instanceof Clients) && !($this->user->provider instanceof Providers)) {
            throw new \Exception("No tiene permisos");
        }

        if($model instanceof Purchases && $model->clients_id !== $this->user->client->id) {
            throw new \Exception("Esta entidad no le pertenece");
        }
    }

    public function checkAccessStatus($action, $model = NULL, $params = []) {
        if($this->user instanceof Users) {
            if( $this->user->provider instanceof Providers && $model instanceof Purchases && $model->product->providers_id !== $this->user->provider->id) {
                throw new \Exception("Esta entidad no le pertenece");
            }
        }

    }
}