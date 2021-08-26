<?php
declare(strict_types=1);
namespace app\apis\facturacion;

use Yii;
use GuzzleHttp\Client;

class Marketplace
{
    /**
     * @var GuzzleHttp\Client
     */
    private $httpClient;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => Yii::$app->params['api_facturacion']['URI'],
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            
        ]);
    }

    public function assoc(array $assoc): ?int
    {
        try {
            $response = $this->client->post('/api/v1/marketplace/assoc', [
                'json' => $assoc,
            ]);

            $bodyResponse = \json_decode((string)$response->getBody());
            if($response->getStatusCode() !== 200) {
                Yii::error($bodyResponse, 'API:FACTURACION');
                return null;
            }

            if($bodyResponse->error) {
                Yii::error($bodyResponse->response, 'API:FACTURACION');
                return null;
            }

            return $bodyResponse->response;

        } catch (\Throwable $th) {
            Yii::error($th->getMessage(), 'API:FACTURACION');
            return null;
        }
    }
}