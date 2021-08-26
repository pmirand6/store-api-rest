<?php 
namespace app\controllers;

use yii\rest\ActiveController;
use app\controllers\BaseController;
use yii\filters\AccessControl;
use app\apis\Auth;
use yii\helpers\ArrayHelper;

class ProductimagesController extends BaseController
{
    public $modelClass = 'app\models\ProductImages';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index', 'view', 'create', 'update', 'delete'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index', 'view', 'update'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        return false;
                    }
                ],
                [
                    'allow' => true,
                    'actions' => ['create', 'delete'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        return $this->authMiddleware($rule, $action);
                    }
                ]
            ],
            'denyCallback' => function($rule, $action){
                throw new \yii\web\ForbiddenHttpException('You are not allowed to perform this action.');
            } 
        ];

        return $behaviors;
    }

}