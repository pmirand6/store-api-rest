<?php 
namespace app\controllers;

use app\models\Clients;
use app\models\Users;
use app\models\QualificationVotes;
use yii\rest\ActiveController;
use app\controllers\BaseController;
use yii\filters\AccessControl;
use app\apis\Auth;
use yii\helpers\ArrayHelper;

class QualificationvotesController extends BaseController
{
    public $modelClass = 'app\models\QualificationVotes';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index', 'create', 'update', 'delete', 'save'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index', 'update', 'delete', 'create'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
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
            'class' => 'app\actions\qualificationvotes\SaveQualificationVoteAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
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

        if($action !== 'create' &&  ($model instanceof QualificationVotes && $model->clients_id !== $this->user->client->id)) {
            throw new \Exception("Esta entidad no le pertenece");
        }
    }
}