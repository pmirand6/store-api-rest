<?php
namespace app\helpers;

class ResponseHelper
{
    public static function run($code, $response = null)
    {

        $response = \Yii::$app->getResponse();
        $response->setStatusCode($code);

        return $response;
    }
}