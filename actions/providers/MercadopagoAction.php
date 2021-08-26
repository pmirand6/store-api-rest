<?php
namespace app\actions\providers;

use yii\rest\Action;
use yii\rest\UpdateAction;
use app\helpers\ResponseHelper;
use app\apis\Auth;
use app\apis\facturacion\Marketplace;
use app\models\Providers;

use Yii;

class MercadopagoAction extends Action
{
    public $modelClass = 'app\models\Providers';

    public function run()
    {
        try {
            $user = Auth::instance()->getUser();
            if(!$user) {
                ResponseHelper::run(500);
                return ['error' => true, 'message' => 'No está registrado'];
            }

            //FIXME con comprobacion valida en caso de ser necesaria
            $provider = $user->provider;

            if(!($provider instanceof Providers)) {
                ResponseHelper::run(500);
                return ['error' => true, 'message' => 'No está registrado como proveedor'];
            }

            $provider = $this->findModel($user->provider->id);

            $params = Yii::$app->getRequest()->getBodyParams();
            $assocMercadopago = (new Marketplace())->assoc([
                'application_id' => Yii::$app->params['mercadopago']['application_id'],
                'vendor_code' => $params['vendor_code'],
                'redirect_uri' => Yii::$app->params['mercadopago']['redirect_uri'],
                'email' => $provider->email,
                'identification_type' => "DNI",
                'identification_number' => $provider->dni,
                'first_name' => $provider->name,
                'last_name' => "", //FIXME : agregar campo apellido
                'provider_address' => $provider->formatted_address,
                'street_name' => $provider->address,
                'street_number' => $provider->street_number,
                'zip_code' => $provider->postal_code
            ]);
            $provider->mercadopago_id = $assocMercadopago ?: $provider->mercadopago_id;

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
            var_dump($th);die;
            ResponseHelper::run(500);
            return ['error' => true, 'message' =>$th->getMessage()];
        }
    }
}

