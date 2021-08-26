<?php
namespace app\actions\clients;

use yii\rest\Action;
use yii\rest\UpdateAction;
use app\helpers\ResponseHelper;
use app\apis\Auth;
use app\models\Users;
use app\models\Clients;
use Yii;

class EditAvatarAction extends Action
{
    public $modelClass = 'app\models\Clients';
    public $user;

    public function run()
    {
        try {
            $user = Auth::instance()->getUser();
            if(!($user instanceof Users)) {
                ResponseHelper::run(500);
                return ['error' => true, 'message' => 'Usuario inexistente'];
            }

            $client = $user->client;

            if(!($client instanceof Clients)) {
                ResponseHelper::run(500);
                return ['error' => true, 'message' => 'Client inexistente'];
            }
        
            if ($this->checkAccess) {
                call_user_func($this->checkAccess, $this->id, $client);
            }
            
            $params = Yii::$app->getRequest()->getBodyParams();

            if(!isset($params['avatar'])){
                ResponseHelper::run(500);
                return ['error' => true, 'message' => 'Ingrese un avatar'];
            }

            if(!in_array($params['avatar'], Clients::avatars())){
                ResponseHelper::run(500);
                return ['error' => true, 'message' => 'Avatar inexistente'];
            }

            $client->load([ 'avatar' => $params['avatar'] ], '');
            $client->image_preference = Yii::$app->params['client_image_preference']['avatar'];
            
            if ($client->save() === false && !$client->hasErrors()) {   
                ResponseHelper::run(500);
                return ['error' => true, 'message' =>'Error al guardar', 'errors' => $client->getErrors()];
            }

            return $client;
        } catch (\Throwable $th) {
            ResponseHelper::run(500);
            return ['error' => true, 'message' =>$th->getMessage()];
        }
    }
}

