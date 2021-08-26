<?php 
namespace app\controllers;

use app\controllers\BaseController;
use yii\filters\AccessControl;
use app\apis\Auth;
use yii\helpers\ArrayHelper;

class ProducttypesController extends BaseController
{
    public $modelClass = 'app\models\ProductTypes';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index', 'view', 'create', 'update', 'delete'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['create'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        return $this->authMiddleware($rule, $action);
                    }
                ],
                [
                    'allow' => true,
                    'actions' => ['index'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        return true;
                    }
                ],
                [
                    'allow' => true,
                    'actions' => ['delete', 'view', 'update'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        return false;
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
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider() 
    {
        $searchModel = new \app\models\ProductTypesSearch();    
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}