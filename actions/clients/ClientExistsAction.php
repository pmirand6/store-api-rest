<?php
namespace app\actions\clients;

use yii\rest\Action;
use app\helpers\ResponseHelper;
use app\apis\Auth;

class ClientExistsAction extends Action
{
    public $modelClass = 'app\models\Clients';

    public function run()
    {
        try {
            $exists = false;
            
            $auth = Auth::instance();
            $user= $auth->getUser(true);
            if($user) {
                $exists = $user->client ? true : false;
            }

            return [ 'exists' => $exists ];
        } catch (\Throwable $th) {
            return ResponseHelper::run(500, $th);
        }
    }
}

