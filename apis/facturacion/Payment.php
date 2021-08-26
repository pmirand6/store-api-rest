<?php
declare(strict_types=1);
namespace app\apis\facturacion;

use Yii;
use GuzzleHttp\Client;

class Payment
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

    public function create(array $payment): string
    {
        try {

            Yii::info(
                json_encode([
                    'message' => 'Envío de payment a facturacion',
                    'method' => __METHOD__,
                    'payment' => $payment
                ]),
                'general'
            );

            $response = $this->client->post('/api/v1/payment', [
                'json' => $payment,
            ]);

            $bodyResponse = \json_decode((string)$response->getBody());
            
            Yii::info(
                json_encode([
                    'message' => 'Respuesta de facturación sobre envío de payment',
                    'method' => __METHOD__,
                    'paymentResponse' => $bodyResponse
                ]),
                'general'
            );

            if($response->getStatusCode() !== 200) {
                Yii::error($bodyResponse, 'purchase');
                throw new \Exception($bodyResponse);
            }

            if($bodyResponse->error) {
                Yii::error(['items' => $payment['items'], 'response' => (string)$response->getBody()], 'purchase');
            }

            return $bodyResponse->status;

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}