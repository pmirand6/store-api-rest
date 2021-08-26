<?php
namespace app\actions\products;

use yii\rest\ViewAction;
use app\helpers\ResponseHelper;
use app\apis\Auth;
use app\models\ViewsHistory;

class ViewProductsAction extends ViewAction
{
    public $modelClass = 'app\models\Products';

    public function run($id)
    {
        try {
            $auth = Auth::instance();
            $user = $auth->getUser(true);
            if($user && $user->client) {
                $viewsHistory = new ViewsHistory;
                $viewsHistory->clients_id = $user->client->id;
                $viewsHistory->products_id = $id;
                $viewsHistory->save();
            }

            return parent::run($id);
        } catch (\Throwable $th) {
            ResponseHelper::run(500);
            return $th->getMessage();
        }
    }
}
