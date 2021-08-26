<?php
namespace app\actions\providers;

use yii\rest\Action;
use app\helpers\ResponseHelper;
use app\apis\Auth;
use app\models\Users;

class ProviderExistsAction extends Action
{
    public $modelClass = 'app\models\Providers';

    public function run()
    {
        try {
            $email = $_GET['email'];
            $exists = false;
            
            if($email) {
                $user = Users::find()
                ->where(['users.email' => $email])
                ->one();

                if($user && $user->provider) {
                    $exists = true;
                }
            }
            
            return [ 'exists' => $exists ];
        } catch (\Throwable $th) {
            return ResponseHelper::run(500, $th);
        }
    }
}

