<?php 
namespace app\controllers;

use app\apis\Auth;
use app\models\Providers;
use app\models\Admins;
use app\models\Users;
use app\controllers\BaseController;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

class ProvidersController extends BaseController
{
    public $modelClass = 'app\models\Providers';
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index', 'view', 'create', 'delete', 'update', 'uploadlogo', 'deleteproviderdeliveries', 'edit', 'exists', 'mercadopago'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index', 'view', 'create', 'update', 'uploadlogo', 'deleteproviderdeliveries', 'mercadopago'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        return $this->authMiddleware($rule, $action);
                    }
                ],
                [
                    'allow' => true,
                    'actions' => ['edit', 'exists'],
                    'roles' => ['?'],
                    'matchCallback' => function ($rule, $action) {
                        $this->authMiddleware($rule, $action, true);
                        return true;
                    }
                ],
                [
                    'allow' => true,
                    'actions' => ['delete'],
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

        $actions = ArrayHelper::merge([
            'uploadlogo' => [
                'class' => 'app\actions\providers\UploadLogoAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],

            ],
            'deleteproviderdeliveries' => [
                'class' => 'app\actions\providers\DeleteProviderDeliveriesAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'edit' => [
                'class' => 'app\actions\providers\EditProviderAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'exists' => [
                'class' => 'app\actions\providers\ProviderExistsAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'mercadopago' => [
                'class' => 'app\actions\providers\MercadopagoAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],

            ],
        ], parent::actions());
        
        $actions['view']['modelClass'] = 'app\models\ProvidersSearch';
        
        return $actions;
    }

    public function verbs()
    {
        $verbs = parent::verbs();

        $verbs['uploadlogo'] = ['POST', 'OPTIONS', 'HEAD'];
        $verbs['mercadopago'] = ['POST', 'OPTIONS', 'HEAD'];
        $verbs['deleteproviderdeliveries'] = ['DELETE', 'OPTIONS'];

        return $verbs;
    }

    public function checkAccess($action, $model = NULL, $params = []) {
        if(!($this->user instanceof Users)) {
            throw new \Exception("No está registrado");
        }

        if($this->user->admin instanceof Admins) {
            return true;
        }

        if(!($this->user->provider instanceof Providers)) {
            throw new \Exception("No tiene permisos de proveedor");
        }

        if($model->id !== $this->user->provider->id) {
            throw new \Exception("Esta entidad no le pertenece");
        }
    }
}