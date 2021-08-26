<?php
declare(strict_types=1);
namespace app\apis;

use Yii;
use GuzzleHttp\Client;

class GoogleSearch
{
    /**
     * @var GuzzleHttp\Client
     */
    private $httpClient;
    
    private $uri;

    public function __construct(string $query)
    {
        $this->uri = "/maps/api/place/findplacefromtext/json?input=$query&inputtype=textquery&fields=photos,formatted_address,name,rating,opening_hours,geometry&key=".Yii::$app->params['GOOGLE_PLACES_TOKEN'];

        $this->client = new Client([
            'base_uri' => "https://maps.googleapis.com/",
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            
        ]);
    }

    public function get(): array
    {
        try {
            $response = $this->client->get($this->uri);

            $bodyResponse = \json_decode((string)$response->getBody(), true);

            if($response->getStatusCode() !== 200) {
                Yii::error($bodyResponse, 'API_GOOGLE');
                throw new \Exception($bodyResponse);
            }

            return $bodyResponse;

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}