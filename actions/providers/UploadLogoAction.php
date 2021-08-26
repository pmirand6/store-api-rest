<?php
namespace app\actions\providers;

use yii\rest\Action;
use app\helpers\ResponseHelper;
use models\Providers;

class UploadLogoAction extends Action
{
    public $modelClass = 'app\models\Providers';

    public function run($id)
    {
        try {
            $provider = $this->findModel($id);

            if ($this->checkAccess) {
                call_user_func($this->checkAccess, $this->id, $provider);
            }
            
            if(!$provider) {
                return ResponseHelper::run(404, ['message' => 'Provider not found']);
            }
            // Guardo el proveedor y se procesa la carga del logo en el modelo
            if($provider->save()) {
                unset($provider->geo);
                return $provider;
            } else {
                throw new Exception(\json_encode($provider->getErrors()));   
            }

            return ResponseHelper::run(500, $provider->getErrors());
        } catch (\Throwable $th) {
            ResponseHelper::run(500);
            return ['error' => true, 'message' => $th->getMessage()];
        }
    }
}

