<?php
namespace app\actions\clients;

use yii\rest\Action;
use app\helpers\ResponseHelper;
use app\models\Clients;

class GetAvatarsAction extends Action
{
    public $modelClass = 'app\models\Users';

    public function run()
    {
        try {
            return [ 'error' => false, 'data' => Clients::avatars() ];
        } catch (\Throwable $th) {
            ResponseHelper::run(500, $th);
            return [ 'error' => true, 'message' => $th->getMessage() ];
        }
    }
}

