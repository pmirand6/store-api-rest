<?php

namespace app\models;

use app\apis\logistica\Nodes;
use app\helpers\CalculateDistanceHelper;
use Carbon\Carbon;
use Yii;
use app\apis\Auth;
use app\helpers\ResponseHelper;
use Exception;
use app\models\Users;
use app\models\Clients;
use app\models\BillingParams;
use app\models\Providers;
use app\models\Addresses;
use GuzzleHttp\Client;
use yii\helpers\Url;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name
 * @property string|null $presentation
 * @property string $volumes_name
 * @property float $volume_value
 * @property string $weights_name
 * @property float $weight_value
 * @property int $requires_cold
 * @property float $clasification
 * @property int $stock
 * @property float $price
 * @property int $reposition_point
 * @property int $delivery_time
 * @property int $expires
 * @property int $expires_time
 * @property string $status
 * @property int $active
 * @property string|null $videos
 * @property string $created_at
 * @property string|null $deleted_at
 * @property string $updated_at
 * @property int $subproduct_typifications_id
 * @property int $providers_id
 * @property int $subproduct_types_id
 * @property int $product_types_id
 *
 * @property ProductImages[] $productImages
 * @property ProductTypes $productTypes
 * @property Providers $providers
 * @property SubproductTypes $subproductTypes
 * @property SubproductTypifications $subproductTypifications
 */
class Products extends \yii\db\ActiveRecord
{
    public $product_image;
    public const DELIVERY_LIMIT_KM = 100;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'volumes_name', 'volume_value', 'weights_name', 'weight_value', 'stock', 'price', 'reposition_point', 'expires', 'expires_time', 'active', 'subproduct_types_id', 'product_types_id'], 'required'],
            [['presentation', 'status', 'videos'], 'string'],
            [['volume_value', 'weight_value', 'clasification', 'price'], 'number'],
            [['stock', 'reposition_point', 'delivery_time', 'expires', 'expires_time', 'active', 'subproduct_typifications_id', 'providers_id', 'subproduct_types_id', 'product_types_id'], 'integer'],
            [['requires_cold'], 'boolean'],
            [['created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['volumes_name', 'weights_name'], 'string', 'max' => 30],
            [['product_types_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductTypes::className(), 'targetAttribute' => ['product_types_id' => 'id']],
            [['providers_id'], 'exist', 'skipOnError' => true, 'targetClass' => Providers::className(), 'targetAttribute' => ['providers_id' => 'id']],
            [['subproduct_types_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubproductTypes::className(), 'targetAttribute' => ['subproduct_types_id' => 'id']],
            [['subproduct_typifications_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubproductTypifications::className(), 'targetAttribute' => ['subproduct_typifications_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'presentation' => 'Presentation',
            'volumes_name' => 'Volumes Name',
            'volume_value' => 'Volume Value',
            'weights_name' => 'Weights Name',
            'weight_value' => 'Weight Value',
            'requires_cold' => 'Requires Cold',
            'clasification' => 'Clasification',
            'stock' => 'Stock',
            'price' => 'Price',
            'reposition_point' => 'Reposition Point',
            'delivery_time' => 'Delivery Time',
            'expires' => 'Expires',
            'expires_time' => 'Expires Time',
            'status' => 'Status',
            'active' => 'Active',
            'videos' => 'Videos',
            'created_at' => 'Created At',
            'deleted_at' => 'Deleted At',
            'updated_at' => 'Updated At',
            'subproduct_typifications_id' => 'Subproduct Typifications ID',
            'providers_id' => 'Providers ID',
            'subproduct_types_id' => 'Subproduct Types ID',
            'product_types_id' => 'Product Types ID',
        ];
    }

    /**
     * Gets query for [[ProductImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImages::className(), ['products_id' => 'id']);
    }

    /**
     * Gets query for [[ProductTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductTypes()
    {
        return $this->hasOne(ProductTypes::className(), ['id' => 'product_types_id']);
    }

    /**
     * Gets query for [[Providers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProviders()
    {
        return $this->hasOne(ProvidersSearch::className(), ['id' => 'providers_id']);
    }

    /**
     * Gets query for [[SubproductTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubproductTypes()
    {
        return $this->hasOne(SubproductTypes::className(), ['id' => 'subproduct_types_id']);
    }

    /**
     * Gets query for [[SubproductTypifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubproductTypifications()
    {
        return $this->hasOne(SubproductTypifications::className(), ['id' => 'subproduct_typifications_id']);
    }

    /**
     * Gets query for [[ProductsHasDeliveryTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductsHasDeliveryTypes()
    {
        return $this->hasMany(ProductsHasDeliveryTypes::className(), ['products_id' => 'id']);
    }

    public function extraFields()
    {
        return [
            'productTypes',
            'subproductTypes',
            'providers',
            'subproductTypifications',
            'productImages',
            'favorites',
            'productsHasDeliveryTypes'
        ];
    }

    public function getFavorites()
    {
        $user = Auth::instance()->getUser(true);
        $client_id = null;

        if ($user && $user->client instanceof Clients) {
            $client_id = $user->client->id;
            $where['favorites.clients_id'] = $client_id;
            $where['favorites.deleted_at'] = null;

            return $this->hasOne(Favorites::className(), [
                'products_id' => 'id'
            ])->onCondition($where);
        } else {
            return $this->hasOne(Favorites::className(), [
                'products_id' => 'id',
            ])->onCondition('1=0');
        }

    }

    /**
     * Gets query for [[ViewsHistory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getViewsHistory()
    {
        return $this->hasMany(ViewsHistory::className(), ['products_id' => 'id']);
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

                $provider = $authUser->provider;
                if (!($provider instanceof Providers)) {
                    ResponseHelper::run(500);
                    return 'No está como proveedor';
                }

                //FIXME QUIT THIS HARDCODE IMMEDIATELY WHEN THE RELATIONS HAS BEEN DEVELOPED
                $this->weights_name = 'KG';
                $this->volumes_name = 'CM3';

                $this->providers_id = $provider->id;
            }

            return parent::beforeSave($insert); // TODO: Change the autogenerated stub
        } catch (Exeption $e) {
            throw new \yii\web\NotFoundHttpException;
        }
    }

    public function getDeliverCost($addressesId, $quantity = 1)
    {
        try {
            $delivertCost = 0;

            $deliveryInfo = $this->getDeliveryInfo($addressesId, $quantity);

            if (isset($deliveryInfo['delivery'])) {
                $delivertCost = [
                    'gross_price' => $deliveryInfo['delivery']['price'],
                    'net_price' => $deliveryInfo['delivery']['net_price'],
                    'iva' => $deliveryInfo['delivery']['iva'],
                ];
            }
        } catch (\Throwable $th) {
            Yii::info($th->getMessage(), 'GetDeliveryCost');
            return [
                'gross_price' => 0,
                'net_price' => 0,
                'iva' => 0,
            ];
        }

        return $delivertCost;
    }

    public function getDeliveryInfo($addressesId, $quantity = 1)
    {
        try {
            $auth = Auth::instance();

            if (!($auth->getUser() instanceof Users)) {
                throw new Exception("No tiene permisos de usuario");
            }

            if (!($auth->getUser()->client instanceof Clients)) {
                throw new Exception("No tiene permisos de cliente");
            }

            $clientAddress = Addresses::findOne([
                'id' => $addressesId,
                'clients_id' => $auth->getUser()->client->id
            ]);

            if (!($clientAddress instanceof Addresses)) {
                throw new Exception('Dirección de cliente no encontrada. address: ' . $addressesId . ' client: ' . $auth->getUser()->client->id);
            }

            $billingParameters = BillingParameters::find()->orderBy('id DESC')->one();
            if (!($billingParameters instanceof BillingParameters)) {
                throw new Exception('Parametros de facturación no existentes.');
            }

            $provider = Providers::findOne($this->providers_id);

            //Get Nodes
            $nearestNodes = (new Nodes())->getNodes($clientAddress->latitude, $clientAddress->longitude);

            //Traigo todos los delivery date para cada modalidad de envio/entrega
            $deliveryDate = $provider->getProductDeliveryDate($this->delivery_time, $nearestNodes);

            if (empty($deliveryDate)) {
                throw new Exception('Error calculando el día de entrega de las modalidades de envío');
            }

            $deliveryTypesModel = $this->productsHasDeliveryTypes;
            if (!$deliveryTypesModel) {
                throw new Exception('ProductsHasDeliveryTypes no asignados');
            }

            foreach ($deliveryTypesModel as $key => $values) {
                $deliveryTypes[] = $values->deliveryType->delivery_type;
            }

            //Fecha de entrega Takeway y distancia en KM entre cliente y proveedor
            if ((in_array("takeaway", $deliveryTypes)) || in_array("delivery", $deliveryTypes)) {
                $distance = (new CalculateDistanceHelper)($clientAddress->geo, $provider->geo);
                $takeaway = $this->setTakeaway($deliveryDate['takeaway'], $distance);

                if ($distance <= self::DELIVERY_LIMIT_KM) {
                    $domicilio = $this->setDelivery($quantity, $billingParameters, $distance, $deliveryDate);
                } else {
                    $domicilio["error"] = true;
                    $domicilio["message"] = "Envío no disponible";
                }
            }

            $allDeliveryModes = [];
            if (in_array("takeaway", $deliveryTypes))
                $allDeliveryModes["takeaway"] = $takeaway;
            if (in_array("delivery", $deliveryTypes))
                $allDeliveryModes["delivery"] = $domicilio;
            if (in_array("node", $deliveryTypes) && !isset($nearestNodes->error)) {
                $allDeliveryModes["nodes"] = $deliveryDate["nodes"];
            }
        } catch (\Throwable $th) {
            Yii::error($th->getMessage(), 'GetDeliveryCost');
            throw new Exception($th->getMessage());
        }

        return $allDeliveryModes;
    }

    public function getPrincipalImage()
    {
        $images = $this->productImages;

        if (isset($images[0])) {
            return Url::base(true) . '/' . str_replace('../web/', '', $images[0]->image);
        }

        return null;
    }

    /**
     * Alertar stock al proveedor
     *
     * @return void
     */
    public function alertStock($quantity): void
    {
        if (($this->stock - $quantity) <= $this->reposition_point) {
            Yii::$app->mailer->compose('products/reposition', [
                'product' => $this,
                'imageUrl' => Yii::$app->params['url'] . "/mailing/images/"
            ])
                ->setFrom('info@feriame.com')
                ->setTo($this->providers->email)
                ->setSubject('Feriame.com | Un producto llegó al nivel de reposición')
                ->send();
        }
    }

    /**
     * @param $takeawayDate
     * @param $distance
     * @return mixed
     */
    private function setTakeaway($takeawayDate, $distance)
    {
        $takeaway = [];
        $takeaway["available_date"] = $takeawayDate;
        $takeaway["distance_km"] = $distance;
        return $takeaway;
    }

    /**
     * @param $quantity
     * @param BillingParameters $billingParameters
     * @param $distance
     * @param array $deliveryDate
     * @param array $domicilio
     * @return array
     */
    private function setDelivery($quantity, BillingParameters $billingParameters, $distance, array $deliveryDate)
    {
        $domicilio = [];
        $finalPrice = 0;
        $productWeight = $this->weight_value * $quantity;

        if ($productWeight <= 20) {
            $finalPrice = $billingParameters->cost_until_20kg + $distance * $billingParameters->cost_per_km_until_20kg;
        } else {
            $finalPrice = $billingParameters->cost_higher_20kg + $distance * $billingParameters->cost_per_km_higher_20kg;
        }

        $domicilio["available_date"] = $deliveryDate['fechaDelivery'];
        $domicilio["net_price"] = $finalPrice;
        $domicilio["iva"] = round($finalPrice * $billingParameters->iva_percent / 100, 2);
        $domicilio["price"] = $domicilio["net_price"] + $domicilio["iva"];
        return $domicilio;
    }
}
