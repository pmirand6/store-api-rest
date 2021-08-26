<?php

namespace app\models;


use Yii;
use app\services\address\AddressService;
use app\apis\Auth;
use app\helpers\ResponseHelper;
use app\models\Provinces;
use app\models\Localities;

/**
 * This is the model class for table "addresses".
 *
 * @property int $id
 * @property string $postal_code
 * @property string $address
 * @property string $street_number
 * @property string $formatted_address
 * @property int $clients_id
 * @property int $localities_id
 * @property int $provinces_id
 *
 * @property Clients $clients
 * @property Provinces $provinces
 * @property Localities $localities
 * @property string $geo [point]
 * @property float $latitude [double]
 * @property float $longitude [double]
 * @property int $updated_at [timestamp]
 * @property int $deleted_at [timestamp]
 * @property int $created_at [timestamp]
 * @property bool $principal [tinyint(1)]
 * @property string $name [varchar(255)]
 * @property string $floor [varchar(100)]
 * @property string $department [varchar(100)]
 * @property string $reference [varchar(255)]
 */
class Addresses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'addresses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['latitude', 'longitude'], 'required'],
            [['latitude', 'longitude'], 'number'],
            [['provinces_id', 'localities_id'], 'integer'],
            [['geo'], 'string'],
            [['principal'], 'boolean'],
            [['postal_code', 'address', 'street_number', 'formatted_address', 'name', 'reference'], 'string', 'max' => 255],
            [['floor', 'department'], 'string', 'max' => 100],
            [['created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['clients_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['clients_id' => 'id']],
            [['localities_id'], 'exist', 'skipOnError' => true, 'targetClass' => Localities::className(), 'targetAttribute' => ['localities_id' => 'id']],
            [['provinces_id'], 'exist', 'skipOnError' => true, 'targetClass' => Provinces::className(), 'targetAttribute' => ['provinces_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'postal_code' => 'Postal Code',
            'address' => 'Address',
            'street_number' => 'Street Number',
            'formatted_address' => 'Formatted Address',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'clients_id' => 'Clients ID',
            'created_at' => 'Created At',
            'deleted_at' => 'Deleted At',
            'updated_at' => 'Updated At',
            'geo' => 'Geo',
            'principal' => 'Principal',
            'name' => 'Name Address',
            'floor' => 'Floor',
            'department' => 'Department',
            'reference' => 'Reference',
            'localities_id' => 'Locality ID',
            'provinces_id' => 'Province ID',
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
     * Gets query for [[Provinces]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvinces()
    {
        return $this->hasOne(Provinces::className(), ['id' => 'provinces_id']);
    }

    /**
     * Gets query for [[Localities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocalities()
    {
        return $this->hasOne(Localities::className(), ['id' => 'localities_id']);
    }

    public function extraFields()
    {
        return [
            'provinces',
            'localities',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $request = Yii::$app->request;


        //FIXME SE IMPLEMENTARA CUANDO SE REALICE LA CORRECTA IMPLEMENTACIÓN DE DIRECCIONES
//        $province = Provinces::getProvinceName($this->provinces_id);
//        $locality = Localities::getLocalityName($this->localities_id);
//        $this->formatted_address = $this->address." ".$this->street_number.", ".($this->postal_code ? $this->postal_code.", " : '') . $locality->locality . ", " . $province->province;

        // Update date
        if (!$insert) {

            $addressService = new AddressService($this, $this->clients);

            switch ($request) {
                case $request->isDelete == true:
                    //Se impide eliminar una dirección principal
                    if ($addressService->isPrincipalAddress() && $request->isDelete) {
                        throw new \Exception("No puede eliminar la única dirección principal");
                    }
                    break;
                case $request->isPut == true:
                    //Si la dirección editada, es principal y desea sacarse como principal y no hay otra, impedir acción
                    if ($addressService->isPrincipalAddress() && $request->bodyParams['principal'] == false) {
                        throw new \Exception("Esta dirección es la única dirección principal, no puede asignarse como no principal");
                    }
                    break;
            }

            $this->updated_at = date('Y-m-d H:i:s', strtotime('NOW'));
        }

        try {
            //Trabajamos los datos de usuario: 
            if ($this->isNewRecord) {
                $auth = Auth::instance();
                $authUser = $auth->getUser();

                if (!$authUser) {
                    throw new \Exception("No está registrado");
                }

                $client = $authUser->client;

                $addressService = new AddressService($this, $client);
                //Si tiene una dirección principal, se seteará el guardado de la dirección como false en el campo principal
                if ($request->bodyParams['principal'] == false) {
                    $this->principal = $addressService->getPrincipalAddress() ? false : true;
                }


                if (!$client) {
                    throw new \Exception("No está registrado como cliente");
                }

                $this->clients_id = $client->id;
            }

            return parent::beforeSave($insert); // TODO: Change the autogenerated stub
        } catch (Exeption $e) {
            throw new \yii\web\NotFoundHttpException;
        }
    }

    public function getFullAddress()
    {
        return $this->formatted_address;
    }

    public function afterSave($insert, $changedAttributes)
    {
        $modelAddress = Addresses::findOne(['id' => $this->id]);
        if ($modelAddress->principal) {
            $addresses = Addresses::find()
                ->where(['not', ['id' => $this->id]])
                ->andWhere(['clients_id' => $this->clients_id])
                ->all();

            foreach ($addresses as $key => $address) {
                $address->principal = false;
                $address->save();
            }
        }
        unset($this->geo);
    }
}
