<?php 
namespace app\controllers;

use app\models\Clients;
use app\models\Users;
use app\controllers\BaseController;
use yii\filters\AccessControl;
use app\apis\Auth;
use yii\helpers\ArrayHelper;

class ClientsController extends BaseController
{
    public $modelClass = 'app\models\Clients';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index', 'view', 'create', 'update', 'delete', 'exists', 'interestgroups', 'edit', 'avatars', 'avatar', 'picture', 'deletepicture'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['create', 'exists'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        $this->authMiddleware($rule, $action, true);
                        return true;
                    }
                ],
                [
                    'allow' => true,
                    'actions' => ['view', 'update', 'delete'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        return false;
                    }
                ],
                [
                    'allow' => true,
                    'actions' => ['index', 'interestgroups', 'edit', 'avatar', 'picture', 'deletepicture'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        return $this->authMiddleware($rule, $action);
                    }
                ],
                [
                    'allow' => true,
                    'actions' => ['sendoffersmail', 'getavatars'],
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
        $actions = ArrayHelper::merge([
            'exists' => [
                'class' => 'app\actions\clients\ClientExistsAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'sendoffersmail' => [
                'class' => 'app\actions\clients\SendOffersMailAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'avatars' => [
                'class' => 'app\actions\clients\GetAvatarsAction',
                'modelClass' => $this->modelClass,
            ],
            'avatar' => [
                'class' => 'app\actions\clients\EditAvatarAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'picture' => [
                'class' => 'app\actions\clients\UploadPictureAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'deletepicture' => [
                'class' => 'app\actions\clients\DeletePictureAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],

        ], $actions);

        $actions['interestgroups'] = [
            'class' => 'app\actions\clients\SaveClientHasInterestGroupsAction',
            'modelClass' => 'app\models\Clients',
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['edit'] = [
            'class' => 'app\actions\clients\EditClientAction',
            'modelClass' => 'app\models\Clients',
            'user' => [$this, 'user'],
        ];
        
        return $actions;
    }

    public function checkAccess($action, $model = NULL, $params = []) {
        if($action !== 'create' && !($this->user instanceof Users)) {
            throw new \Exception("No está registrado");
        }

        if($action !== 'create' && !($this->user->client instanceof Clients)) {
            throw new \Exception("No existe el cliente.");
        }

        if($model instanceof Clients && $model->id !== $this->user->client->id) {
            throw new \Exception("Esta entidad no le pertenece");
        }
    }
}