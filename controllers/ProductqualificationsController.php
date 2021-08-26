<?php 
namespace app\controllers;

use yii\rest\ActiveController;
use app\controllers\BaseController;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class ProductqualificationsController extends BaseController
{
    public $modelClass = 'app\models\ProductQualifications';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index', 'create', 'update', 'delete', 'view'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index', 'create', 'update', 'delete'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        return false;
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
            'class' => 'app\actions\productqualifications\ViewProductQualificationAction',
            'modelClass' => $this->modelClass,
        ];

        return $actions;
    }
}