<?php
declare(strict_types=1);

namespace app\models\tools;

use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Yii;
use app\models\Purchases;
use app\models\Addresses;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use yii\helpers\Url;

/**
 * Class CreateShippingFromPurchaseTool
 * @package app\models\tools
 */
class CreateShippingFromPurchaseTool
{
    /**
     * @var Purchases
     */
    private $purchase;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var RequestInterface
     */
    private $response;

    /**
     * CreateShippingFromPurchaseTool constructor.
     * @param Purchases $purchase
     * @param string $token
     * @throws GuzzleException
     */
    public function __construct(Purchases $purchase, string $token)
    {
        $this->purchase = $purchase;

        Yii::info(
            json_encode([
                'message' => 'Create Shipping',
                'method' => __METHOD__,
                'payload' => $purchase
            ]),
            'general'
        );

        $fields = [
            'node_id' => $purchase->node_id,
            'providerAddress' => $purchase->product->providers->formatted_address,
            'provider_name' => $purchase->product->providers->name,
            'provider_email' => $purchase->product->providers->user->email,
            'status' => 'PRODUCT_ORDER_CONFIRMED',
            'orderDate' => date('Y-m-d H:i:s'),
            'product' => $purchase->product->name,
            'product_price' => $purchase->product->price,
            'product_id' => $purchase->products_id,
            'product_description' => $purchase->product->presentation,
            'clientName' => $purchase->client->name ? $purchase->client->name . ' ' . $purchase->client->lastname : '',
            'client_phone_number' => $purchase->client->phone_prefix ? $purchase->client->phone_prefix . '-' . $purchase->client->phone_number : $purchase->client->phone_number,
            'client_identification_number' => $purchase->client->dni,
            'deliveryType' => $purchase->deliveryType->delivery_type,
            'productImageUrl' => count($purchase->product->productImages) >= 1 ? Url::base(true) . str_replace('../web', '', $purchase->product->productImages[0]->image) : '',
            'quantity' => $purchase->quantity,
            'estimated_delivery_date' => $purchase->estimated_delivery_date,
            'requires_cold' => $purchase->product->requires_cold,
            'purchaseOrder' => $purchase->purchaseOrders->purchase_order_code,
            'customer_delivery_address' => $purchase->addresses instanceof Addresses ? $purchase->addresses->getFullAddress() : null,
            'client_email' => $purchase->client->user->email,
        ];

        try {
            $this->client = new Client([
                'base_uri' => Yii::$app->params['api_logistica']['URI'],
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json'
                ],

            ]);
            $apiUrl = 'shippings';
            $this->response = $this->client->post($apiUrl, [
                'json' => $fields,
            ]);

            Yii::info(
                json_encode([
                    'message' => 'Shipping Result',
                    'method' => __METHOD__,
                    'response' => $this->response
                ]),
                'general'
            );
        } catch (ClientException $e) {
            Yii::error(
                json_encode([
                    'message' => 'Shipping Result',
                    'method' => __METHOD__,
                    'response' => $this->response
                ]),
                'general'
            );
            return ['error' => true, 'message' => $e->getMessage()];
        } catch (\Exception $e) {
            Yii::error(
                json_encode([
                    'message' => 'Shipping Result',
                    'method' => __METHOD__,
                    'response' => $this->response
                ]),
                'general'
            );
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    /**
     * @return RequestInterface
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getShippingCode(): string
    {
        if ($this->response->getStatusCode() !== 201) {
            throw new \Exception("Error on create shipping");
        }

        return (\json_decode((string)$this->response->getBody()))->data->shipping_code;
    }
}