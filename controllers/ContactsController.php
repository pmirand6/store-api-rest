<?php 
namespace app\controllers;

use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use app\models\Contacts;
use app\apis\Recaptcha;
use app\helpers\ResponseHelper;

class ContactsController extends BaseController
{
    public $modelClass = 'app\models\Contacts';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => [ 'index', 'view', 'create', 'update', 'delete' ],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => [ 'index', 'view', 'update', 'delete' ],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        return $this->authMiddleware($rule, $action);
                    }
                ],
                [
                    'allow' => true,
                    'actions' => [ 'create' ],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        return true;
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
        
        $actions['create']['checkAccess'] = [$this, 'checkAccess'];

        return $actions;
    }

    public function checkAccess($action, $model = NULL, $params = [])
    {
        try {
            $verify = (new Recaptcha())->verify();
    
            if(!$verify->success) {
                throw new \Exception("Recaptcha error " . json_encode($verify));
            }
    
            if($verify->success && $verify->score < 0.1) {
                throw new \Exception("Score error: " . $verify->score);
            }
        } catch (\Throwable $th) {
            ResponseHelper::run(500);
            throw new \Exception($th->getMessage());
        }

    }
}