<?php 
namespace app\controllers;

use app\controllers\BaseController;
use yii\filters\AccessControl;
use app\apis\Auth;
use yii\helpers\ArrayHelper;
use app\models\Users;

class UsersController extends BaseController
{
    public $modelClass = 'app\models\Users';

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
                'exists', 
                'info', 
                'createpushtokens',
                'deletepushtokens'
            ],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['exists', 'info', 'createpushtokens', 'deletepushtokens'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        return $this->authMiddleware($rule, $action);
                    }
                ],
                [
                    'allow' => true,
                    'actions' => ['info'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        $this->authMiddleware($rule, $action, true);
                        return true;
                    }
                ],
                [
                    'allow' => true,
                    'actions' => ['index', 'view', 'create', 'update', 'delete'],
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

        $actions = ArrayHelper::merge([
            'info' => [
                'class' => 'app\actions\users\InfoAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'createpushtokens' => [
                'class' => 'app\actions\users\CreatePushTokenAction',
                'modelClass' => 'app\models\PushTokens',
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'deletepushtokens' => [
                'class' => 'app\actions\users\DeletePushTokenAction',
                'modelClass' => 'app\models\PushTokens',
                'checkAccess' => [$this, 'checkAccess'],
                'getToken' => [$this, 'getToken'],
            ],
        ], $actions);

        return $actions;
    }

    public function prepareDataProvider() 
    {
        $searchModel = new \app\models\UsersSearch();    
        return $searchModel->search(\Yii::$app->request->queryParams);
    }

    public function actionExists()
    {
        $email = \Yii::$app->request->get('email');
        $exists = Users::find()->where(['email' => $email])->exists();

        return $exists;
    }

    public function getToken()
    {
        return \Yii::$app->request->getBodyParam('token');
    }

}