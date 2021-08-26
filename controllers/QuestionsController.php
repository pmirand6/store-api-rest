<?php 
namespace app\controllers;

use app\models\Clients;
use app\models\Providers;
use app\models\Users;
use yii\rest\ActiveController;
use app\controllers\BaseController;
use yii\filters\AccessControl;
use app\apis\Auth;
use yii\helpers\ArrayHelper;

class QuestionsController extends BaseController
{
    public $modelClass = 'app\models\Questions';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index', 'create', 'update', 'delete', 'save', 'view', 'answer'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['create', 'answer'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        return $this->authMiddleware($rule, $action);
                    }
                ],
                [
                    'allow' => true,
                    'actions' => ['view'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        return true;
                    }
                ],
                [
                    'allow' => true,
                    'actions' => ['update', 'delete', 'index'],
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
        
        $actions['create']['checkAccess'] = [$this, 'checkAccessClient'];
        
        $actions['answer'] = [
            'class' => 'app\actions\questions\AnswerQuestionAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccessProvider'],
        ];
        
        $actions['view'] = [
            'class' => 'app\actions\IndexAction',
            'modelClass' => 'app\models\Questions',
            'prepareDataProvider' => [$this, 'prepareDataProvider'],
        ];

        return $actions;
    }

    public function checkAccessProvider($action, $model = NULL, $params = []) {
        if(!($this->user instanceof Users)) {
            throw new \Exception("No está registrado");
        }

        if(!($this->user->provider instanceof Providers)) {
            throw new \Exception("No es un proveedor.");
        }

        if($model->products->providers_id !== $this->user->provider->id) {
            throw new \Exception("Esta entidad no le pertenece");
        }
    }

    public function checkAccessClient($action, $model = NULL, $params = []) {
        if(!($this->user instanceof Users)) {
            throw new \Exception("No está registrado");
        }

        if(!($this->user->client instanceof Clients)) {
            throw new \Exception("No existe el cliente.");
        }
    }

    public function prepareDataProvider() 
    {
        $searchModel = new \app\models\QuestionsSearch();   
        $params = \Yii::$app->request->queryParams;
        
        $params['filter']['questions.products_id'] = \Yii::$app->request->get('id');

        return $searchModel->search($params);
    }
}