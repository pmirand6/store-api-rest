<?php
namespace app\actions\productqualifications;

use yii\rest\Action;
use app\helpers\ResponseHelper;
use Exception;
use app\models\ProductQualifications;

class ViewProductQualificationAction extends Action
{
    public $modelClass = 'app\models\ProductQualifications';

    public function run($id)
    {
        try {
           return [ 'error' => false, 'data' => $this->modelClass::findOne(['id' => $id])];
        } catch (\Throwable $th) {
            ResponseHelper::run(500);
            return [ 'error' => true, 'message' => $th->getMessage() ];
        }
    }
}

