<?php 
namespace app\controllers;

use app\controllers\BaseController;
use yii\filters\AccessControl;
use app\apis\Auth;
use yii\helpers\ArrayHelper;

class ProvincesController extends BaseController
{
    public $modelClass = 'app\models\Provinces';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index', 'view', 'create', 'update', 'delete'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index', 'view', 'create', 'update', 'delete'],
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

        $actions['view'] = [
            'class' => 'app\actions\IndexAction',
            'modelClass' => 'app\models\ProvincesSearch',
            'prepareDataProvider' => [$this, 'prepareDataProvider'],
        ];
        return $actions;
    }

    public function prepareDataProvider() 
    {
        $searchModel = new \app\models\ProvincesSearch();
        $params = \Yii::$app->request->queryParams;

        $params['filter']['countries_id'] = \Yii::$app->request->get('id');

        return $searchModel->search($params);
    }
}