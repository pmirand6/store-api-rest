<?php
namespace app\helpers;

use Yii;
use GuzzleHttp\Client;

class SendPushHelper
{
    private $client;
    private $response;

    public function __construct(array $fields)
    {
        $apiUrl = Yii::$app->params['firebase_api_url'];
        $key = Yii::$app->params['firebase_token'];

        $this->client = new Client();
        $this->response = $this->client->request('POST', $apiUrl, [
            'body' => \json_encode($fields),
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => "key=$key",
            ]
        ]);
    }

    public function getResponse()
    {
        return $this->response;
    }
}