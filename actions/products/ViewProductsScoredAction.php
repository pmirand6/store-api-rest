<?php
namespace app\actions\products;

use yii\rest\ViewAction;
use app\helpers\ResponseHelper;
use app\apis\Auth;
use app\models\ViewsHistory;

class ViewProductsScoredAction extends ViewAction
{
    public $modelClass = 'app\models\ProductsScored';

    public function run($id)
    {
        try {
            $modelClass = $this->modelClass;

            $model = $modelClass::find()->where(['id' => $id])->one();
            
            return $model;
        } catch (\Throwable $th) {
            ResponseHelper::run(500);
            return [ 'error' => true, 'message' => $th->getMessage() ];
        }
    }
}
