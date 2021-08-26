<?php
namespace app\actions\addresses;

use yii\rest\Action;
use app\helpers\ResponseHelper;
use Yii;
use app\apis\GoogleSearch;

class GetGeoAction extends Action
{
    public $modelClass = 'app\models\Addresses';

    public function run($query)
    {
        try {
            return (new GoogleSearch($query))->get();
        } catch (\Throwable $th) {
            ResponseHelper::run(500);
            return [ 'error' => true, 'message'  => $th->getMessage()];
        }
    }
}
