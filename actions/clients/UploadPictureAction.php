<?php
namespace app\actions\clients;

use yii\rest\Action;
use app\helpers\ResponseHelper;
use app\apis\Auth;
use app\models\Users;
use app\models\Clients;
use yii\helpers\Url;
use Exception;
use Yii;

class UploadPictureAction extends Action
{
    public $modelClass = 'app\models\Clients';

    public function run()
    {
        try {
            $user = Auth::instance()->getUser();
            if(!($user instanceof Users)) {
                throw new Exception('Usuario inexistente', 1);
            }

            $client = $user->client;

            if(!($client instanceof Clients)) {
                throw new Exception('Client inexistente', 1);
            }
        
            if ($this->checkAccess) {
                call_user_func($this->checkAccess, $this->id, $client);
            }
            
            $bodyParams = Yii::$app->getRequest()->getBodyParams();

            if(isset($bodyParams['picture']))
            {
                if (!file_exists($client->picturePath)) {
                    throw new Exception('Directorio de imagenes no creado');
                }

                if(is_file($client->picturePath . $client->id . '.png')) {
                    unlink($client->picturePath . $client->id . '.png');
                }

                $path = $client->picturePath . $client->id . '.png';
                
                $imgFile = $this->getB64Image($bodyParams['picture']);
                file_put_contents($path, $imgFile);

                $client->picture = Url::base(true) . '/pictures/clients/' . $client->id . '.png';
                $client->image_preference = Yii::$app->params['client_image_preference']['picture'];

                if(!$client->save()) {
                    throw new Exception(\json_encode($client->getErrors()));
                }
            } else {
                throw new Exception('Ingrese una imagen en el campo picture');
            }
        } catch (\Throwable $th) {
            ResponseHelper::run(500);
            return [ 'error' => true, 'message' => $th->getMessage() ];
        }

        return $client;
    }


    private function getB64Image($base64_image)
    {
        $image_service_str = substr($base64_image, strpos($base64_image, ",") + 1);
        $image = base64_decode($image_service_str);

        return $image;
    }
}

