<?php

namespace app\apis\logistica;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Yii;

class Nodes
{
    /**
     * @var GuzzleHttp\Client
     */
    private $httpClient;

    public function __construct()
    {
        $params = Yii::$app->getRequest()->getHeaders();
        $authorization = $params['authorization'];
        $this->httpClient = new Client([
            'base_uri' => Yii::$app->params['api_logistica']['URI'],
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'authorization' => $authorization
            ],
        ]);
    }

    public function getNodes($latitude, $longitude)
    {
        try {
            $response = $this->httpClient->request('GET', 'nodes/getNearest/?latitude=' . $latitude . '&longitude=' . $longitude);

            return json_decode($response->getBody()->getContents());

        } catch (GuzzleException $e) {
        }
    }

    public function getNode(string $nodeId)
    {
        try {
            $response = $this->httpClient->request('GET', 'nodes/' . $nodeId);

            return json_decode($response->getBody()->getContents());

        } catch (GuzzleException $e) {
        }
    }


}