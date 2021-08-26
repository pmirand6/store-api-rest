<?php
namespace app\actions\contracts;

use yii\rest\Action;
use app\helpers\ResponseHelper;
use app\apis\Auth;
use app\models\Users;
use app\models\Providers;
use app\models\Contracts;

class GetLastContractAction extends Action
{
    public $modelClass = 'app\models\Contracts';
    public $type;
    
    public function run()
    {
        try {
            $modelClass = $this->modelClass;
            $model = $modelClass::getLastContract($this->type);

            if($this->type === Contracts::TYPE_PROVIDER) {
                $user = Auth::instance()->getUser(true);
                if(!($user instanceof Users)) {
                    ResponseHelper::run(500);
                    return ['error' => true, 'message' => 'Usuario inexistente'];
                }

                $provider = $user->provider;

                if(!($provider instanceof Providers)) {
                    ResponseHelper::run(500);
                    return ['error' => true, 'message' => 'Proveedor inexistente'];
                }

                $model->contract = $provider->replaceMacros( $model->contract );
            }
            
            return $model;
        } catch (\Throwable $th) {
            ResponseHelper::run(500);
            return $th->getMessage();
        }
    }
}
