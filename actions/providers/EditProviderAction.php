<?php
namespace app\actions\providers;

use yii\rest\Action;
use yii\rest\UpdateAction;
use app\helpers\ResponseHelper;
use app\apis\Auth;
use Yii;

class EditProviderAction extends Action
{
    public $modelClass = 'app\models\Providers';

    public function run()
    {
        try {
            $user = Auth::instance()->getUser();
            if(!$user) {
                ResponseHelper::run(500);
                return ['error' => true, 'message' => 'Usuario inexistente'];
            }

            $provider = $user->provider;

            if(!$provider) {
                ResponseHelper::run(500);
                return ['error' => true, 'message' => 'Proveedor inexistente'];
            }
        
            if ($this->checkAccess) {
                call_user_func($this->checkAccess, $this->id, $provider);
            }
            
            $provider = $this->findModel($provider->id);
            $provider->load(Yii::$app->getRequest()->getBodyParams(), '');
            if ($provider->save() === false && !$provider->hasErrors()) {
                ResponseHelper::run(500);
                return ['error' => true, 'message' => 'Failed to update the object for unknown reason.'];
            }
            
            if($provider->hasErrors()) {    
                ResponseHelper::run(500);
                return ['error' => true, 'message' =>'Error al guardar', 'errors' => $provider->getErrors()];
            }

            unset($provider->geo);
            return $provider;
        } catch (\Throwable $th) {
            ResponseHelper::run(500);
            return ['error' => true, 'message' =>$th->getMessage()];
        }
    }
}

