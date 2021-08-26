<?php
namespace app\actions\users;

use yii\rest\Action;
use app\helpers\ResponseHelper;
use app\apis\Auth;
use Exception;
use app\models\Users;

class InfoAction extends Action
{
    public $modelClass = 'app\models\Users';

    public function run()
    {
        try {
            $auth = Auth::instance();
            $user = $auth->getUser();

            if(!($user instanceof Users)) {
                return null;
            }

            return $user;
        } catch (\Throwable $th) {
            ResponseHelper::run(500);
            return $th->getMessage();
        }
    }
}

