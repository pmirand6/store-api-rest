<?php 
namespace app\controllers;

use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use app\apis\Auth;

class FavoritesController extends BaseController
{
    public $modelClass = 'app\models\Favorites';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index', 'view', 'create', 'update', 'delete', 'add'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index', 'create', 'view', 'update'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        return false;
                    }
                ],
                [
                    'allow' => true,
                    'actions' => ['add', 'delete'],
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

    public function actions() 
    {
        $actions = parent::actions();

        $actions['delete']['class'] = 'app\actions\favorites\RemoveFavoriteAction';

        $actions['add'] = [
            'class' => 'app\actions\favorites\AddFavoriteAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        return $actions;
    }
}