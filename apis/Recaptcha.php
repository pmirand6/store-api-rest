<?php

declare(strict_types=1);
namespace app\apis;

use Yii;
use GuzzleHttp\Client;

class Recaptcha
{
    /**
     * @var GuzzleHttp\Client
     */
    private $httpClient;

    private $secret;
    private $responseRecaptcha;
    private $remoteIp;

    public function __construct()
    {
        try {
            $this->httpClient = new Client();
    
            $requestParams = Yii::$app->getRequest()->getBodyParams();

            if(!isset($requestParams['response'])) {
                throw new \Exception('response recaptcha es necesario.');
            }
    
            $this->responseRecaptcha = $requestParams['response'];
            $this->remoteIp = $_SERVER['REMOTE_ADDR'];
            $this->secret = Yii::$app->params['RECAPTCHA_SECRET'];
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage);
        }
    }

    public function verify()
    {
        try {
            $responseVerify = $this->httpClient->post('https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => [
                    'secret' => $this->secret,
                    'response' => $this->responseRecaptcha,
                    'remoteip' => $this->remoteIp
                ]
            ]);

            if($responseVerify->getStatusCode() !== 200){
                throw new \Exception('Error al consultar la verificación.');
            }

            $responseObject = \json_decode((string)$responseVerify->getBody());
            
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }

        return $responseObject;
    }
}