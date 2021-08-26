<?php
namespace app\actions\favorites;

use Yii;
use yii\rest\Action;
use yii\web\ServerErrorHttpException;
use app\apis\Auth;
use app\models\Favorites;
use app\helpers\ResponseHelper;

class AddFavoriteAction extends Action
{
    public function run($id)
    {
        try {
            $user = Auth::instance()->getUser();

            if(!$user) {
                ResponseHelper::run(401);
                return 'El usuario no está registrado.';
            }

            $client = $user->client;

            if(!$client) {
                ResponseHelper::run(401);
                return 'No está registrado como cliente.';
            }

            $model = Favorites::findOne([
                'products_id' => $id, 
                'clients_id' => $client->id
            ]);
    
            if(!$model) {
                $model = new Favorites();
                $model->products_id = $id;
                $model->clients_id = $client->id;
            } else {
                $model->deleted_at = null;
            }
    
            if ($this->checkAccess) {
                call_user_func($this->checkAccess, $this->id, $model);
            }
    
    
            if ($model->save() === false) {
                ResponseHelper::run(500);
                return $model->getErrors();
            }
            
            return $model;
        } catch (\Throwable $th) {
            ResponseHelper::run(500);
            return $th->getMessage();
        }
    }
}
