<?php 
namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use app\apis\Auth;
use app\apis\Auth0Management;
use Yii;

class BaseController extends ActiveController {
    protected $token;
    protected $user;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page']
            ]

        ];

        return $behaviors;
    }

    public function authMiddleware($rule, $action, $low = false)
    {
        try {
            $auth = Auth::instance();
            
            $this->user = $auth->getUser($low);
            return $auth->checkPermission("$this->id/$action->id");
        } catch (\Throwable $th) {
            if(!$low) {
                throw new \yii\web\ForbiddenHttpException($th->getMessage());
            }
        }
            
    }
}