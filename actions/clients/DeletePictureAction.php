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

class DeletePictureAction extends Action
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
            
            if (!file_exists($client->picturePath)) {
                throw new Exception('Directorio de imagenes no creado');
            }

            if(is_file($client->picturePath . $client->id . '.png')) {
                unlink($client->picturePath . $client->id . '.png');
            }

            $client->picture = NULL;

            if ($client->avatar){
                $client->image_preference = Yii::$app->params['client_image_preference']['avatar'];
            }else{
                $client->image_preference = NULL;
            }

            if(!$client->save()) {
                throw new Exception(\json_encode($client->getErrors()));
            }
        } catch (\Throwable $th) {
            ResponseHelper::run(500);
            return [ 'error' => true, 'message' => $th->getMessage() ];
        }

        return $client;
    }
}

