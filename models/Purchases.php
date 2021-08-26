<?php

namespace app\models;

use app\apis\logistica\Nodes;
use Carbon\Carbon;
use Yii;
use app\apis\Auth;
use Da\QrCode\QrCode;
use yii\helpers\Url;
use app\models\tools\CreateShippingFromPurchaseTool;
use app\helpers\UuidGenerator;
use app\helpers\ResponseHelper;
use Exception;

/**
 * This is the model class for table "purchases".
 *
 * @property int $id
 * @property int $clients_id
 * @property int $products_id
 * @property int $delivery_types_id
 * @property int $addresses_id
 * @property int $quantity
 * @property float|null $delivery_cost
 * @property float|null $service_cost
 * @property string $created_at
 * @property string|null $deleted_at
 * @property string $updated_at
 * @property string $shipping_status
 * @property string $shipping_status_code
 *
 * @property Addresses $addresses
 * @property Clients $clients
 * @property DeliveryTypes $deliveryTypes
 * @property Products $products
 */
class Purchases extends \yii\db\ActiveRecord
{

    public $distance;
    public $path = __DIR__ . '/../web/qr/purchases/';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchases';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['products_id', 'delivery_types_id', 'addresses_id', 'quantity'], 'required'],
            [['clients_id', 'products_id', 'delivery_types_id', 'addresses_id', 'quantity'], 'integer'],
            [['delivery_cost', 'service_cost'], 'number'],
            [['purchase_code', 'shipping_code'], 'string', 'max' => 6],
            [['shipping_status', 'shipping_status_code'], 'string', 'max' => 255],
            [['node_id'], 'string', 'max' => 36],
            [['created_at', 'deleted_at', 'updated_at', 'estimated_delivery_date'], 'safe'],
            [['addresses_id'], 'exist', 'skipOnError' => true, 'targetClass' => Addresses::className(), 'targetAttribute' => ['addresses_id' => 'id']],
            [['clients_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['clients_id' => 'id']],
            [['delivery_types_id'], 'exist', 'skipOnError' => true, 'targetClass' => DeliveryTypes::className(), 'targetAttribute' => ['delivery_types_id' => 'id']],
            [['products_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['products_id' => 'id']],
            [['purchase_orders_id'], 'exist', 'skipOnError' => true, 'targetClass' => PurchaseOrders::className(), 'targetAttribute' => ['purchase_orders_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'clients_id' => 'Clients ID',
            'products_id' => 'Products ID',
            'delivery_types_id' => 'Delivery Types ID',
            'addresses_id' => 'Addresses ID',
            'quantity' => 'Quantity',
            'delivery_cost' => 'Delivery Cost',
            'service_cost' => 'Service Cost',
            'created_at' => 'Created At',
            'deleted_at' => 'Deleted At',
            'updated_at' => 'Updated At',
            'purchase_orders_id' => 'Purchase Orders ID',
            'purchase_code' => 'Purchase Code',
            'estimated_delivery_date' => 'Estimated Delivery Date',
            'node_id' => 'Node ID',
            'shipping_code' => 'Shipping Code',
            'shipping_status' => 'Shipping Status',
            'shipping_status_code' => 'Shipping Status Code',
        ];
    }

    /**
     * Gets query for [[Addresses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasOne(Addresses::className(), ['id' => 'addresses_id']);
    }

    /**
     * Gets query for [[Clients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['id' => 'clients_id']);
    }

    /**
     * Gets query for [[DeliveryTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveryType()
    {
        return $this->hasOne(DeliveryTypes::className(), ['id' => 'delivery_types_id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'products_id']);
    }

    /**
     * Gets query for [[PurchaseOrders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrders()
    {
        return $this->hasOne(PurchaseOrders::className(), ['id' => 'purchase_orders_id']);
    }

    public function extraFields()
    {
        return [
            'product',
            'client',
            'deliveryType',
            'qualification'
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // Update date
        if (!$insert) {
            $this->updated_at = date('Y-m-d H:i:s', strtotime('NOW'));
        }

        try {
            //Trabajamos los datos de usuario: 
            if ($this->isNewRecord) {
                $auth = Auth::instance();
                $authUser = $auth->getUser();

                if (!($authUser instanceof Users)) {
                    ResponseHelper::run(500);
                    return 'No está registrado';
                }

                $client = $authUser->client;
                if (!($client instanceof Clients)) {
                    ResponseHelper::run(500);
                    return 'No está como cliente';
                }

                // Set ClientId
                $this->clients_id = $client->id;

                // Set purchase_code
                $this->purchase_code = (new UuidGenerator)(6);

                $statusPurchaseOrder = $this->purchaseOrders->status;

                if ($statusPurchaseOrder == 'approved') {
                    // set shipping_code
                    $this->shipping_code = (new CreateShippingFromPurchaseTool($this, $auth->getToken()))->getShippingCode();

                    // set shipping_status inicial
                    $this->shipping_status = 'Compra Confirmada';
                    $this->shipping_status_code = 'PRODUCT_ORDER_CONFIRMED';
                } else {
                    //FIXME Establecer tipo de estado y código para este error
                    $this->shipping_status = $statusPurchaseOrder;
                    $this->shipping_status_code = $statusPurchaseOrder;
                    $this->shipping_code = $statusPurchaseOrder;
                }
            }

            return parent::beforeSave($insert);
        } catch (Exeption $e) {
            throw new \yii\web\NotFoundHttpException;
        }
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $this->sendQR();
            $this->alertPurchaseConfirmClient();
            $this->alertSell();
        } else {
            $this->sendPackedNotification();
            $this->sendProductoEntregado();
            $this->sendAvailableInNodeNotification();
            $this->sendOnRoadNotification();
            $this->sendNotDeliveredNotification();
        }
    }

    private function sendQR()
    {
        // Crear QR
        $qrCode = $this->getQR();

        // Enviar QR al cliente
        if ($this->deliveryType instanceof DeliveryTypes && $this->deliveryType->delivery_type === 'takeaway') {
            Yii::$app->mailer->compose('purchases/takeaway', ['purchase' => $this])
                ->setFrom('info@feriame.com')
                ->setTo($this->client->user->email)
                ->attach($qrCode)
                ->setSubject('Feriame.com | QR Pedido Takeaway')
                ->send();
        }
    }

    public function getQR()
    {
        $qrCode = (new QrCode($this->shipping_code))
            ->setSize(250)
            ->setMargin(5)
            ->useForegroundColor(0, 0, 0);
        $qr = $this->path . $this->shipping_code . '.png';
        $qrCode->writeFile($qr);

        return $qr;
    }

    /**
     * Gets query for [[Qualifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQualification()
    {
        return $this->hasOne(Qualifications::className(), ['purchases_id' => 'id']);
    }

    private function sendPackedNotification()
    {
        // Enviar QR al cliente
        if ($this->deliveryType instanceof DeliveryTypes && $this->deliveryType->delivery_type === 'takeaway' && $this->shipping_status_code === 'PACKED') {
            // Crear QR
            $qrCode = $this->getQR();
            Yii::$app->mailer->compose('purchases/takeawaypacked', [
                'purchase' => $this,
                'imageUrl' => Yii::$app->params['url'] . "/mailing/images/",
                'qrUrl' => Yii::$app->params['url'] . "/qr/purchases/",
            ])
                ->setFrom('info@feriame.com')
                ->setTo($this->client->user->email)
                ->attach($qrCode)
                ->setSubject('Feriame.com | Pedido listo para retirar')
                ->send();
        }
    }

    private function sendOnRoadNotification()
    {
        $params = Yii::$app->getRequest()->getBodyParams();
        $shippingResource = $params['resource'];
        $today = Carbon::now()->format('d/m/Y');
        // Enviar QR al cliente
        if ($this->deliveryType instanceof DeliveryTypes && $this->deliveryType->delivery_type === 'delivery' && $this->shipping_status_code === 'ON_ROAD') {
            // Crear QR
            $qrCode = $this->getQR();
            Yii::$app->mailer->compose('purchases/onroad', [
                'purchase' => $this,
                'shippingResource' => $shippingResource,
                'today' => $today,
                'imageUrl' => Yii::$app->params['url'] . "/mailing/images/",
                'qrUrl' => Yii::$app->params['url'] . "/qr/purchases/",
            ])
                ->setFrom('info@feriame.com')
                ->setTo($this->client->user->email)
                ->attach($qrCode)
                ->setSubject('Feriame.com | Estamos llevandote tu pedido!')
                ->send();
        }
    }

    private function sendNotDeliveredNotification()
    {
        $params = Yii::$app->getRequest()->getBodyParams();
        $shippingResource = $params['resource'];
        $today = Carbon::now()->format('d/m/Y');
        $node = $params['node'][0];
        // Enviar QR al cliente
        if ($this->deliveryType instanceof DeliveryTypes && $this->deliveryType->delivery_type === 'delivery' && $this->shipping_status_code === 'NOT_DELIVERED') {
            // Crear QR
            $qrCode = $this->getQR();
            Yii::$app->mailer->compose('purchases/notdelivered', [
                'purchase' => $this,
                'shippingResource' => $shippingResource,
                'today' => $today,
                'node' => $node,
                'imageUrl' => Yii::$app->params['url'] . "/mailing/images/",
                'qrUrl' => Yii::$app->params['url'] . "/qr/purchases/",
            ])
                ->setFrom('info@feriame.com')
                ->setTo($this->client->user->email)
                ->attach($qrCode)
                ->setSubject('Feriame.com | Te visitamos en el día de hoy')
                ->send();
        }
    }

    private function sendAvailableInNodeNotification()
    {
        $params = Yii::$app->getRequest()->getBodyParams();
        $node = $params['node'][0];
        // Enviar QR al cliente
        if ($this->deliveryType instanceof DeliveryTypes && $this->deliveryType->delivery_type === 'node' && $this->shipping_status_code === 'AVAILABLE_IN_NODE') {
            // Crear QR
            $qrCode = $this->getQR();
            Yii::$app->mailer->compose('purchases/availableinnode', [
                'purchase' => $this,
                'node' => $node,
                'imageUrl' => Yii::$app->params['url'] . "/mailing/images/",
                'qrUrl' => Yii::$app->params['url'] . "/qr/purchases/",
            ])
                ->setFrom('info@feriame.com')
                ->setTo($this->client->user->email)
                ->attach($qrCode)
                ->setSubject('Feriame.com | Pedido listo para retirar')
                ->send();
        }
    }

    private function sendProductoEntregado()
    {
        if ($this->shipping_status_code === 'ACCEPTED') {
            Yii::$app->mailer->compose('purchases/entregado', ['purchase' => $this, 'imageUrl' => Yii::$app->params['url'] . "/mailing/images/"])
                ->setFrom('info@feriame.com')
                ->setTo($this->client->user->email)
                ->setSubject('Feriame.com | Tu pedido ya fue entregado')
                ->send();
        }
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function alertPurchaseConfirmClient(): void
    {
        if ($this->shipping_status_code === 'PRODUCT_ORDER_CONFIRMED') {
            $params = Yii::$app->getRequest()->getBodyParams();
            //FIXME IMPLEMENTAR CACHE PARA ESTA QUERY YA QUE LOS NODOS NO VAN A CAMBIAR
            $node = (new Nodes())->getNode($this->node_id);
            Yii::$app->mailer->compose('purchases/comprarealizadacliente',
                [
                    'purchase' => $this,
                    'imageUrl' => Yii::$app->params['url'] . "/mailing/images/",
                    'node' => $node
                ]
            )
                ->setFrom('info@feriame.com')
                ->setTo($this->client->user->email)
                ->setSubject('Feriame.com | Tu compra ha sido confirmada')
                ->send();
        }
    }

    public function alertSell(): void
    {
        if ($this->shipping_status_code === 'PRODUCT_ORDER_CONFIRMED') {
            Yii::$app->mailer->compose('purchases/nuevasventasproveedor', [
                    'purchase' => $this,
                    'imageUrl' => Yii::$app->params['url'] . "/mailing/images/",
                    'providerName' => $this->product->providers->name
                ]
            )
                ->setFrom('info@feriame.com')
                ->setTo($this->product->providers->email)
                ->setSubject('Feriame.com | Hiciste nuevas ventas')
                ->send();
        }
    }

    public function fields()
    {
        $fields = parent::fields();

        $fields['qr_code_path'] = function ($model) {
            return Url::base(true) . "/qr/purchases/" . $model->shipping_code . ".png";
        };

        return $fields;
    }
}
