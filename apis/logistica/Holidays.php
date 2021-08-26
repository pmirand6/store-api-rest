<?php


namespace app\apis\logistica;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Yii;

class Holidays
{
    /**
     * @var GuzzleHttp\Client
     */
    private $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client([
            'base_uri' => Yii::$app->params['api_logistica']['URI'],
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function getHolidaysDates()
    {
        try {
            $holidays = [];
            $response = $this->httpClient->request('GET', 'holidays');
            $holidaysResponse = json_decode($response->getBody()->getContents());

            foreach ($holidaysResponse->data as $holiday) {
                $holidays[] = $holiday->date;
            }
            return $holidays;

        } catch (GuzzleException $e) {
            return $e->getMessage();
        }
    }

}