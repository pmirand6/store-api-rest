<?php

namespace app\models;

use Yii;
use app\helpers\UuidGenerator;
use app\helpers\ResponseHelper;
use Exception;
use app\apis\Auth;
use app\apis\facturacion\Payment;

/**
 * This is the model class for table 'purchase_orders'.
 *
 * @property int $id
 * @property string $purchase_order_code
 * @property int $clients_id
 *
 * @property Clients $clients
 * @property Purchases[] $purchases
 */
class PurchaseOrders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchase_orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['purchase_order_code', 'clients_id'], 'safe'],
            [['clients_id'], 'integer'],
            [['purchase_order_code'], 'string', 'max' => 6],
            [['status'], 'string', 'max' => 255],
            [['user_agent'], 'string'],
            [['ip'], 'string', 'max' => 100],
            [['clients_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['clients_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'purchase_order_code' => 'Purchase Order Code',
            'clients_id' => 'Clients ID',
            'ip' => 'IP',
            'user_agent' => 'User Agent',
        ];
    }

    /**
     * Gets query for [[Clients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasOne(Clients::className(), ['id' => 'clients_id']);
    }

    /**
     * Gets query for [[Purchases]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPurchases()
    {
        return $this->hasMany(Purchases::className(), ['purchase_orders_id' => 'id']);
    }

    /**
     * @param bool $insert
     * @return bool|string
     * @throws \yii\web\NotFoundHttpException
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        try{
            //Trabajamos los datos de usuario: 
            if($this->isNewRecord) {
                $auth = Auth::instance();
                $authUser = $auth->getUser();

                if(!($authUser instanceof Users)) {
                    ResponseHelper::run(500);
                    return 'No está registrado';
                }

                $client = $authUser->client;
                if(!($client instanceof Clients)) {
                    ResponseHelper::run(500);
                    return 'No está como cliente';
                }

                // Set ClientId
                $this->clients_id = $client->id;

                // Set purchase_code
                $this->purchase_order_code = (new UuidGenerator)(6);

                // TODO: Calcular el costo de envio no tomar el que viene
            }
            
            return parent::beforeSave($insert);
        } catch(Exeption $e) {
            throw new \yii\web\NotFoundHttpException;
        }
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @return string
     * @throws Exception
     */
    public function afterSave($insert, $changedAttributes)
    {
        try {
            if(!$insert) {
                $this->restoreStock();
                $this->alertStock();
            }

            if($insert) {
                $bodyParams = Yii::$app->getRequest()->getBodyParams();
                
                if(!isset($bodyParams['payment'])) {
                    throw new \Exception("Ingrese los datos del payment");
                }
                
                if(!isset($bodyParams['payer'])) {
                    throw new \Exception("Ingrese los datos del payer");
                }


                $auth = Auth::instance();
                $authUser = $auth->getUser();

                if(!($authUser instanceof Users)) {
                    ResponseHelper::run(500);
                    return 'No está registrado';
                }

                $client = $authUser->client;
                if(!($client instanceof Clients)) {
                    ResponseHelper::run(500);
                    return 'No está registrado como cliente';
                }

                $payer = $bodyParams['payer'];
                $payerAddress = $this->getPayerAddress();

                if(!is_null($payerAddress)){
                    $payer['address'] = $payerAddress;
                }

                $payer['name'] = $client->name;
                $payer['lastname'] = $client->lastname;

                $payment = [
                    'payment' => $bodyParams['payment'],
                    'payer' => $payer,
                    'items' => $this->getPaymentItems()
                ];

                $payment['payment']['external_reference'] = $this->purchase_order_code;
                $this->status = (new Payment())->create($payment);

                // User Track Data
                $this->ip = Yii::$app->request->getRemoteIP();
                $this->user_agent = Yii::$app->request->getUserAgent();

                $this->save();
            }
        } catch (\Throwable $th) {
            $this->status = 'error';
            $this->save();
            throw new \Exception($th);
        }
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    private function getPaymentItems(): array
    {
        $idErp = 'fer-111';

        $items = [];

        $bodyParams = Yii::$app->getRequest()->getBodyParams();

        foreach ($bodyParams['purchases'] as $purchase) {
            $product = Products::findOne($purchase['products_id']);
            $deliveryType = DeliveryTypes::findOne($purchase['delivery_types_id']);

            $deliveryCost = $deliveryType->delivery_type === 'delivery' ? $product->getDeliverCost($purchase['addresses_id'], $purchase['quantity']) : 0;

            if($deliveryType->delivery_type === 'delivery' && $deliveryCost['net_price'] === 0) {
                Yii::error("Costo de envio 0 en envio a domicilio", 'purchase');
                throw new Exception("Costo de envio 0 en envio a domicilio");
            }

            $items[] = [
                'item_name' => $product->name,
                'item_code' => $product->id,
                'unit_price' => number_format($product->price, 2, ".", ''),
                'subtotal' => number_format($product->price * $purchase['quantity'], 2, ".", ''),
                'quantity' => $purchase['quantity'],
                'provider' => [
                    'id_marketplace' => (string) $product->providers->mercadopago_id,
                    'id_provider' => $product->providers_id,
                    'id_erp' => $idErp,
                ],
                'delivery_type' => $deliveryType->delivery_type,
                'net_delivery_cost' => $deliveryType->delivery_type === 'delivery' ? number_format($deliveryCost['net_price'], 2, ".", '') : '0.00',
                'iva_delivery_cost' => $deliveryType->delivery_type === 'delivery' ? number_format($deliveryCost['iva'], 2, ".", '') : '0.00',
                'delivery_cost' => $deliveryType->delivery_type === 'delivery' ? number_format($deliveryCost['gross_price'], 2, ".", '') : '0.00',
                'weight_item' => $product->weight_value,
                'unit_of_measurement' => $product->weights_name
            ];
        }
        
        return $items;
    }


    /**
     * @throws \yii\base\InvalidConfigException
     */
    private function alertStock()
    {
        $bodyParams = Yii::$app->getRequest()->getBodyParams();
        $purchases = $bodyParams['purchases'];
        if($this->status === 'approved'){
            foreach ($purchases as $purchase) {
                $product = Products::findOne($purchase['products_id']);
                $product->alertStock($purchase['quantity']);
            }
        }
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    private function restoreStock()
    {
        $bodyParams = Yii::$app->getRequest()->getBodyParams();
        $purchases = $bodyParams['purchases'];
        if($this->status !== 'approved'){
            foreach ($purchases as $purchase) {
                $product = Products::findOne($purchase['products_id']);
                $product->stock = $product->stock + $purchase['quantity'];
                $product->save();
            }
        }
    }

    /**
     * @return array|null
     * @throws \yii\base\InvalidConfigException
     */
    private function getPayerAddress(): ?array
    {
        $bodyParams = Yii::$app->getRequest()->getBodyParams();

        foreach ($bodyParams['purchases'] as $purchase) {
            $product = Products::findOne($purchase['products_id']);
            $deliveryType = DeliveryTypes::findOne($purchase['delivery_types_id']);

            $deliveryCost = $deliveryType->delivery_type === 'delivery' ? $product->getDeliverCost($purchase['addresses_id'], $purchase['quantity']) : 0;

            $address = Addresses::findOne($purchase['addresses_id']);
            return [
                'customer_address' => $address->formatted_address,
                'street_name' => $address->address,
                'street_number' => $address->street_number,
                'zip_code' => $address->postal_code,
                'provinces_code' => $address->provinces->code,
                'localities_code' => $address->localities->code
            ]; 

        }

        return null;
    }
}
