<?php 
namespace app\controllers;

use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use app\apis\Auth;

class DeliverytypesController extends BaseController
{
    public $modelClass = 'app\models\DeliveryTypes';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => [ 'index',  'view',  'create',  'update',  'delete' ],
            'rules' => [
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
                    'actions' => [ 'view',  'create',  'update',  'delete' ],
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

}