<?php 
namespace app\controllers;

use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use app\apis\Auth;
use app\models\Clients;
use app\models\Users;
use app\models\Providers;
use app\models\Admins;
use Exception;

class ProductsController extends BaseController
{
    public $modelClass = 'app\models\Products';
    public $searchClass = 'app\models\ProductsScored';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => [
                'index', 
                'view', 
                'create', 
                'update', 
                'delete', 
                'search', 
                'see', 
                'history', 
                'deliverytypes', 
                'searchindex', 
                'suggestions',
                'score',
                'scorezero',
                'scoreone',
                'scoretwo',
                'scorethree',
                'scorefour',
                'scorefive',
            ],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => [
                        'see',
                        'search',
                        'searchindex',
                        'score',
                        'scorezero',
                        'scoreone',
                        'scoretwo',
                        'scorethree',
                        'scorefour',
                        'scorefive',
                    ],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        $this->authMiddleware($rule, $action, true);
                        return true;
                    }
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'index', 
                        'view', 
                        'create', 
                        'update', 
                        'delete', 
                        'history', 
                        'deliverytypes', 
                        'suggestions'
                    ],
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

        $actions['search'] = [
            'class' => 'app\actions\IndexAction',
            'modelClass' => $this->searchClass,
            // 'checkAccess' => [$this, 'checkAccess'],
            'prepareDataProvider' => [$this, 'prepareDataProvider'],
        ];

        $actions['index'] = [
            'class' => 'app\actions\IndexAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'prepareDataProvider' => [$this, 'prepareIndexDataProvider'],
        ];

        $actions['see'] = [
            'class' => 'app\actions\products\ViewProductsAction',
            'modelClass' => $this->searchClass,
            // 'checkAccess' => [$this, 'checkAccess'],
        ];
        
        $actions['history'] = [
            'class' => 'app\actions\IndexAction',
            'modelClass' => 'app\models\ViewsHistory',
            'checkAccess' => [$this, 'clientCheckAccess'],
            'prepareDataProvider' => [$this, 'prepareHistoryDataProvider'],
        ];
        
        $actions['deliverytypes'] = [
            'class' => 'app\actions\products\SaveProductsDeliveryTypesAction',
            'modelClass' => 'app\models\Products',
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['suggestions'] = [
            'class' => 'app\actions\IndexAction',
            'modelClass' => $this->searchClass,
            'checkAccess' => [$this, 'clientCheckAccess'],
            'prepareDataProvider' => [$this, 'prepareSuggestionsDataProvider'],
        ];

        $actions['delivery'] = [
            'class' => 'app\actions\products\DeliveryMethodAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['totalscore'] = [
            'class' => 'app\actions\products\ViewTotalProductsScoredAction',
        ];

        $actions['score'] = [
            'class' => 'app\actions\products\ViewProductsScoredAction',
            'modelClass' => 'app\models\ProductsScored',
        ];

        return $actions;
    }

    public function prepareDataProvider() 
    {
        $searchModel = new \app\models\ProductsScoredSearch();   
        $params = \Yii::$app->request->queryParams;
        
        return $searchModel->search($params);
    }

    public function prepareHistoryDataProvider() 
    {
        $searchModel = new \app\models\ViewsHistorySearch();    

        $user = Auth::instance()->getUser(true);
        $client_id = null;

        if($user && $user->client) {
            $client_id = $user->client->id;
        }

        $params =  \Yii::$app->request->queryParams;
        $params['filter']['clients_id'] = $client_id;

        return $searchModel->search($params);
    }

    public function prepareIndexDataProvider() 
    {
        try {
            $searchModel = new \app\models\ProductsIndexSearch();   
            $params      = \Yii::$app->request->queryParams;
    
            $user        = Auth::instance()->getUser();
            $provider_id = null;
    
            if(!($user instanceof Users)) {
                throw new Exception("No está registrado.");
            }
    
            if(!($user->admin instanceof Admins) && !($user->provider instanceof Providers)) {
                throw new Exception("No tiene permisos para ejecutar esta acción,");
            }

            
            $params =  \Yii::$app->request->queryParams;
            
            if(!($user->admin instanceof Admins)) {
                $params['filter']['products.providers_id'] = $user->provider->id;
            }
            
            return $searchModel->search($params);
        } catch (\Throwable $th) {
            throw new Exception($th);
        }
    }

    public function prepareSuggestionsDataProvider() 
    {
        $searchModel = new \app\models\ProductsSuggestionsSearch();   
        $params      = \Yii::$app->request->queryParams;

        $user        = Auth::instance()->getUser();
        
        $params =  \Yii::$app->request->queryParams;
        
        return $searchModel->search($params, $user->client->id);
    }

    public function checkAccess($action, $model = NULL, $params = []) {
        if(!($this->user instanceof Users)) {
            throw new \Exception("No está registrado");
        }

        if($this->user->admin instanceof Admins) {
            return true;
        }

        if(!($this->user->provider instanceof Providers)) {
            throw new \Exception("No tiene permisos de proveedor");
        }

        if($model instanceof Products && $model->providers_id !== $this->user->provider->id) {
            throw new \Exception("Esta entidad no le pertenece");
        }
    }

    public function clientCheckAccess($action, $model = NULL, $params = []) {
        if(!($this->user instanceof Users)) {
            throw new \Exception("No está registrado");
        }

        if(!($this->user->client instanceof Clients)) {
            throw new \Exception("No está registrado como cliente");
        }
    }
}