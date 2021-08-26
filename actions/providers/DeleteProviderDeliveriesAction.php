<?php
namespace app\actions\providers;

use yii\rest\Action;
use app\helpers\ResponseHelper;
use app\models\ProviderDeliveries;

class DeleteProviderDeliveriesAction extends Action
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

            // Eliminar todos las entidades 'ProviderDeliveries' asociadas
            return ProviderDeliveries::deleteAll(['providers_id' => $provider->id]);
        } catch (\Throwable $th) {
            return ResponseHelper::run(500, $th);
        }
    }
}

