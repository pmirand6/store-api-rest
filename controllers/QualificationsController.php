<?php 
namespace app\controllers;

use app\models\Clients;
use app\models\Users;
use yii\rest\ActiveController;
use app\controllers\BaseController;
use yii\filters\AccessControl;
use app\apis\Auth;
use yii\helpers\ArrayHelper;

class QualificationsController extends BaseController
{
    public $modelClass = 'app\models\Qualifications';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index', 'create', 'update', 'delete', 'save', 'view'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['view'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        $this->authMiddleware($rule, $action, true);
                        return true;
                    }
                ],
                [
                    'allow' => true,
                    'actions' => ['index', 'create', 'update', 'delete'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        $this->authMiddleware($rule, $action);
                        return false;
                    }
                ],
                [
                    'allow' => true,
                    'actions' => ['save'],
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
        
        $actions['save'] = [
            'class' => 'app\actions\qualifications\SaveQualificationAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['view'] = [
            'class' => 'app\actions\IndexAction',
            'modelClass' => 'app\models\QualificationsLikes',
            'prepareDataProvider' => [$this, 'prepareDataProvider'],
        ];

        return $actions;
    }

    public function checkAccess($action, $model = NULL, $params = []) {
        if(!($this->user instanceof Users)) {
            throw new \Exception("No está registrado");
        }

        if(!($this->user->client instanceof Clients)) {
            throw new \Exception("No existe el cliente.");
        }

        if($model->purchase->clients_id !== $this->user->client->id) {
            throw new \Exception("Esta entidad no le pertenece");
        }
    }

    public function prepareDataProvider() 
    {
        $searchModel = new \app\models\QualificationsSearch();   
        $params = \Yii::$app->request->queryParams;
        
        $params['filter']['qualification_likes.products_id'] = \Yii::$app->request->get('id');

        return $searchModel->search($params);
    }
}