<?php 
namespace app\controllers;

use app\controllers\BaseController;
use yii\filters\AccessControl;
use app\apis\Auth;
use yii\helpers\ArrayHelper;

class ProviderimagesController extends BaseController
{
    public $modelClass = 'app\models\ProviderImages';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index', 'view', 'create', 'update', 'delete'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['delete', 'create'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        return $this->authMiddleware($rule, $action);
                    }
                ],
                [
                    'allow' => true,
                    'actions' => ['index', 'view', 'update'],
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
}