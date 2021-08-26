<?php 
namespace app\controllers;

use app\models\Clients;
use app\models\Users;
use yii\rest\ActiveController;
use app\controllers\BaseController;
use yii\filters\AccessControl;
use app\apis\Auth;
use yii\helpers\ArrayHelper;

class AddressesController extends BaseController
{
    public $modelClass = 'app\models\Addresses';

    //2º method calles when POST to /addresses enpoint
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index', 'create', 'update', 'delete', 'geo'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index', 'create', 'update','delete', 'geo'],
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

    //1º method calles when POST to /addresses enpoint
    public function actions() 
    { 
        $actions = parent::actions();
        
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        $actions['index']['modelClass'] = 'app\models\AddressesSearch';
        $actions['view']['modelClass'] = 'app\models\AddressesSearch';
        
        $actions['delete'] = [
            'class' => 'app\actions\SoftDeleteAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        
        $actions['geo'] = [
            'class' => 'app\actions\addresses\GetGeoAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccessUser'],
        ];

        return $actions;
    }

    public function prepareDataProvider() 
    {
        $searchModel = new \app\models\AddressesSearch();    

        $user = Auth::instance()->getUser();
        
        if(!($user instanceof Users)) {
            throw new \Exception("No está registrado.");
        }

        if(!($user->client instanceof Clients)) {
            throw new \Exception("No está registrado como cliente.");
        }

        $client_id = $user->client->id;

        $params =  \Yii::$app->request->queryParams;
        $params['filter']['clients_id'] = $client_id;

        return $searchModel->search($params);
    }

    //3º method calles when POST to /addresses enpoint
    public function checkAccess($action, $model = NULL, $params = []) {
        if($action !== 'create' && !($this->user instanceof Users)) {
            throw new \Exception("No está registrado");
        }

        if($action !== 'create' && !($this->user->client instanceof Clients)) {
            throw new \Exception("No existe el cliente.");
        }

        if($model instanceof Clients && $model->id !== $this->user->client->id) {
            throw new \Exception("Esta entidad no le pertenece");
        }
    }

    public function checkAccessUser($action, $model = NULL, $params = []) {
        if(!($this->user instanceof Users)) {
            throw new \Exception("No está registrado");
        }
    }
}