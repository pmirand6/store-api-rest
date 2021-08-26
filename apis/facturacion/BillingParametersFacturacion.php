<?php
declare(strict_types=1);
namespace app\apis\facturacion;

use Yii;
use GuzzleHttp\Client;

class BillingParametersFacturacion
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

    public function create(array $billingparams): string
    {
        try {
            $response = $this->client->post('/api/v1/billingparameters', [
                'json' => $billingparams,
            ]);

            $bodyResponse = \json_decode((string)$response->getBody());

            if($response->getStatusCode() !== 200) {
                Yii::error($bodyResponse, 'billingparams');
                throw new \Exception($bodyResponse);
            }

            if($bodyResponse->error) {
                Yii::error(['params' => $billingparams, 'response' => (string)$response->getBody()], 'billingparams');
            }

            return $bodyResponse->response;

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}