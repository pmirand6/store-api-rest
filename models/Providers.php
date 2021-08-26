<?php

namespace app\models;

use app\apis\logistica\Holidays;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Yii;
use app\apis\Auth;
use app\apis\Auth0Management;
use app\actions\contracts\GetLastContractAction;
use kartik\mpdf\Pdf;

/**
 * This is the model class for table "providers".
 *
 * @property int $id
 * @property string $name
 * @property string $business_name
 * @property float $clasification
 * @property float $latitude
 * @property float $longitude
 * @property string $floor
 * @property string $department_number
 * @property int $training
 * @property string|null $logo
 * @property float $phone_number
 * @property string $email
 * @property int $participate_fairs
 * @property int|null $signature
 * @property string|null $signature_date
 * @property int $active
 * @property string $created_at
 * @property string|null $deleted_at
 * @property string $updated_at
 * @property int $users_id
 * @property int $provider_types_id
 *
 * @property Products[] $products
 * @property ProviderContacts[] $providerContacts
 * @property ProviderDeliveries[] $providerDeliveries
 * @property ProviderImages[] $providerImages
 * @property ProviderTaxes[] $providerTaxes
 * @property ProviderTypes $providerTypes
 * @property Users $users
 * @property string $geo [point]
 * @property string $videos
 * @property int $contracts_id [bigint]
 * @property int $dni [int]
 * @property string $postal_code [varchar(255)]
 * @property string $address [varchar(255)]
 * @property string $street_number [varchar(255)]
 * @property string $formatted_address [varchar(255)]
 * @property float $mercadopago_id [double]
 * @property int $provinces_id [bigint]
 * @property int $localities_id [bigint]
 */
class Providers extends \yii\db\ActiveRecord
{
    public $path = "../web/uploads/providerlogo/";
    public $legalPath = "../web/legal/providers/";

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'providers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'business_name', 'latitude', 'longitude', 'training', 'phone_number', 'email', 'participate_fairs', 'provider_types_id', 'dni'], 'required'],
            [['clasification', 'phone_number', 'latitude', 'longitude'], 'number'],
            [['participate_fairs', 'active', 'users_id', 'provider_types_id', 'provinces_id', 'localities_id', 'dni'], 'integer'],
            [['geo'], 'string'],
            [['postal_code', 'address', 'street_number', 'formatted_address'], 'string', 'max' => 255],
            [['signature', 'training'], 'boolean'],
            [['signature_date', 'created_at', 'deleted_at', 'updated_at', 'videos'], 'safe'],
            [['name', 'business_name', 'logo'], 'string', 'max' => 100],
            [['floor'], 'string', 'max' => 10],
            [['department_number'], 'string', 'max' => 6],
            [['email'], 'string', 'max' => 150],
            [['mercadopago_id'], 'number'],
            [['mercadopago_id'], 'unique'],
            [['provider_types_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProviderTypes::className(), 'targetAttribute' => ['provider_types_id' => 'id']],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['users_id' => 'id']],
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
            'name' => 'Name',
            'business_name' => 'Business Name',
            'clasification' => 'Clasification',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'floor' => 'Floor',
            'department_number' => 'Department Number',
            'training' => 'Training',
            'logo' => 'Logo',
            'phone_number' => 'Phone Number',
            'email' => 'Email',
            'participate_fairs' => 'Participate Fairs',
            'signature' => 'Signature',
            'signature_date' => 'Signature Date',
            'active' => 'Active',
            'created_at' => 'Created At',
            'deleted_at' => 'Deleted At',
            'updated_at' => 'Updated At',
            'users_id' => 'Users ID',
            'provider_types_id' => 'Provider Types ID',
            'videos' => 'videos',
            'geo' => 'Geo',
            'dni' => 'DNI',
            'postal_code' => 'Postal Code',
            'address' => 'Address',
            'street_number' => 'Street Number',
            'formatted_address' => 'Formatted Address',
            'mercadopago_id' => 'Mercadopago ID',
            'localities_id' => 'Locality ID',
            'provinces_id' => 'Province ID',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['providers_id' => 'id']);
    }

    /**
     * Gets query for [[ProviderContacts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProviderContacts()
    {
        return $this->hasMany(ProviderContacts::className(), ['providers_id' => 'id']);
    }

    /**
     * Gets query for [[ProviderDeliveries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProviderDeliveries()
    {
        return $this->hasMany(ProviderDeliveries::className(), ['providers_id' => 'id']);
    }

    /**
     * Gets query for [[ProviderImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProviderImages()
    {
        return $this->hasMany(ProviderImages::className(), ['providers_id' => 'id']);
    }

    /**
     * Gets query for [[ProviderTaxes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProviderTaxes()
    {
        return $this->hasOne(ProviderTaxes::className(), ['providers_id' => 'id']);
    }

    /**
     * Gets query for [[ProviderType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProviderType()
    {
        return $this->hasOne(ProviderTypes::className(), ['id' => 'provider_types_id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }

    /**
     * Gets query for [[Contract]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContract()
    {
        return $this->hasOne(Contracts::className(), ['id' => 'contracts_id']);
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
            'providerContacts',
            'providerDeliveries',
            'providerStatuses',
            'user',
            'providerImages',
            'providerTaxes',
            'providerType',
            'provinces',
            'localities',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        //FIXME SE IMPLEMENTARA CUANDO SE REALICE LA CORRECTA IMPLEMENTACIÓN DE DIRECCIONES
//        $province = Provinces::getProvinceName($this->provinces_id);
//        $locality = Localities::getLocalityName($this->localities_id);
//        $this->formatted_address = $this->address." ".$this->street_number.", ".($this->postal_code ? $this->postal_code.", " : '') . $locality->locality . ", " . $province->province;

        // Update date
        if (!$insert) {
            $this->updated_at = date('Y-m-d H:i:s', strtotime('NOW'));
        }
        $auth = Auth::instance();

        $oldModel = $insert ? $this : self::findOne($this->id);
        $contract = Contracts::getLastContract(Contracts::TYPE_PROVIDER);

        $signatureDate = (new \DateTime($oldModel->signature_date))->format('Y-m-d');
        $contractDate = $contract->updated_at ? new \DateTime($contract->updated_at) : new \DateTime($contract->created_at);
        $contractDate = $contractDate->format('Y-m-d');


        if (($oldModel && !$oldModel->signature && $this->signature) || ($oldModel->contracts_id !== $contract->id)) {
            if ($this->signature) {
                $this->contracts_id = $contract ? $contract->id : null;
                $this->signature_date = date('Y-m-d');
            }
            if (!$insert) {
                // Asignar role al usuario al aceptar los terminos y condiciones
                $auth0Management = new Auth0Management();
                $auth0Management->assignUserToRole($auth->getTokenInfo()['sub'], 'Proveedor');
            }
        }

        try {
            if (isset($_FILES['logo'])) {
                if ($oldModel && is_file($this->path . $oldModel->logo)) {
                    unlink($this->path . $oldModel->logo);
                }

                if (!file_exists($this->path)) {
                    mkdir($this->path, 0777, true);
                }

                if (!file_exists($this->path . $this->id)) {
                    mkdir($this->path . $this->id, 0777, true);
                }

                $path = $this->path . $this->id . "/" . basename($_FILES['logo']['name'] . rand());
                move_uploaded_file($_FILES['logo']['tmp_name'], $path);

                $this->logo = $path;
            }

            //Trabajamos los datos de usuario: 
            if ($this->isNewRecord) {
                $authUser = Users::findOne(['email' => $this->email]);

                if ($authUser) {
                    if ($authUser->provider) {
                        throw new \Error('El usuario ya se encuentra registrado como proveedor.');
                    }

                    $user = $authUser;
                } else {
                    $user = new Users;
                    $user->email = $this->email;
                }

                if (!$user->save()) {
                    $errors = json_encode($user->getErrors());
                    throw new \Error($errors);
                }

                $this->users_id = $user->id;
            }

            return parent::beforeSave($insert); // TODO: Change the autogenerated stub
        } catch (Exeption $e) {
            throw new \yii\web\NotFoundHttpException;
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            Yii::$app->mailer->compose('providers/new', [
                'provider' => $this,
                'url' => Yii::$app->params['front']['URI'],
                'imageUrl' => Yii::$app->params['url'] . "/mailing/images/",
            ])
                ->setFrom('info@feriame.com')
                ->setTo($this->user->email)
                ->setSubject('Feriame.com | Bienvenido a Feriame')
                ->send();
        } else {
            if (in_array('signature_date', array_keys($changedAttributes))) {
                try {
                    //code...
                    $this->logSignature();
                    $this->sendContract();
                } catch (\Throwable $th) {
                    var_dump($th);
                    die;
                }
            }
        }
    }

    public function logSignature()
    {
        $log = new ProviderSignatureHistory();
        $log->providers_id = $this->id;
        $log->ip = Yii::$app->request->getRemoteIP();
        $log->user_agent = Yii::$app->request->getUserAgent();

        $log->save();
    }

    /**
     * Obtener fechas de delivery de todas las modalidades de entrega
     * @param $daysOfProduction
     * @param $nearestNodes
     * @return array
     */
    public function getProductDeliveryDate($daysOfProduction, $nearestNodes)
    {
        $requestDate = Carbon::now()->timezone('America/Buenos_Aires');

        $providerDeliveries = $this->providerDeliveries;
        if (!$providerDeliveries) {
            return [];
        }

        foreach ($providerDeliveries as $key => $values) {
            $attentionSchedule[] = $values->day;
        }

        $holidays = (new Holidays())->getHolidaysDates();

        //Obtenemos el dia que va a retirar logistica el paquete
        $collectionDate = $this->getCollectionDate($requestDate, $attentionSchedule, $daysOfProduction, $holidays, $fechaTakeAway);
        $nodeCollectionDate = clone $collectionDate;
        $fechaDelivery = clone $collectionDate;

        Yii::info(
            json_encode([
                    'message' => 'Resultado de fechas de delivery de todas las modalidades de entrega',
                    'method' => __METHOD__,
                    'takeaway' => $fechaTakeAway->format('d/m/Y'),
                    'fechaDelivery' => $this->getDeliveryDate($collectionDate, $holidays),
                    'nodes' => $this->getNodesDeliveryDate($nodeCollectionDate, $holidays, $nearestNodes)
                ]),
            'general'
        );

        return [
            'takeaway' => $fechaTakeAway->format('d/m/Y'),
            'fechaDelivery' => $this->getDeliveryDate($fechaDelivery, $holidays),
            'nodes' => $this->getNodesDeliveryDate($nodeCollectionDate, $holidays, $nearestNodes)
        ];

    }

    private function checkLaboralDay($requestDate, $holidays)
    {
        return $requestDate->isWeekend() || in_array($requestDate->format('Y-m-d'), $holidays);
    }

    public function convertDayName($day)
    {
        switch ($day) {
            case 'Sun':
                return "Dom";
                break;

            case 'Mon':
                return "Lun";
                break;

            case 'Tue':
                return "Mar";
                break;

            case 'Wed':
                return "Mie";
                break;

            case 'Thu':
                return "Jue";
                break;

            case 'Fri':
                return "Vie";
                break;

            case 'Sat':
                return "Sab";
                break;

            default:
                return "Date not valid.";
                break;
        }
    }

    public function sendContract()
    {
        $content = $this->replaceMacros($this->contract->contract);

        $pdf = new Pdf([
            'filename' => $this->user->email . '-provider-legal-signature-' . date('Y-m-d_H:i:s') . '.pdf',
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_FILE,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Feriame.com - Contract Provider - ' . $this->user->email],
        ]);

        $path = $this->legalPath . $this->user->email . '/';

        // check if exist legal path for provider
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $pdf->output($content, $path . $pdf->filename, Pdf::DEST_FILE);


        Yii::$app->mailer->compose('providers/signature', [
            'provider' => $this,
            'imageUrl' => Yii::$app->params['url'] . "/mailing/images/"
        ])
            ->setFrom('info@feriame.com')
            ->setTo($this->user->email)
            ->setSubject('Feriame.com | Términos y condiciones de Feriame')
            ->attach($path . $pdf->filename)
            ->send();
    }

    public function getResponsable()
    {
        $responsable = null;
        if (count($this->providerContacts) > 0) {
            foreach ($this->providerContacts as $providerContact) {
                if ($providerContact->responsable) {
                    return $providerContact;
                }
            }
        }

        return $responsable;
    }

    public function replaceMacros($text): ?string
    {
        $response = $text;
        foreach ($this->getAttributes() as $attribute => $value) {
            $response = str_replace('{' . $attribute . '}', $value, $response);
        }

        $responsable = $this->getResponsable();
        $responsableFirstName = $responsable instanceof ProviderContacts ? $responsable->firstname : null;
        $responsableLastName = $responsable instanceof ProviderContacts ? $responsable->lastname : null;
        $responsableDni = $responsable instanceof ProviderContacts ? $responsable->dni : null;

        $billingParameters = BillingParameters::find()->one();
        $configCommission = $billingParameters instanceof BillingParameters ? $billingParameters->commission_percent : null;

        $cuit = $this->providerTaxes instanceof ProviderTaxes ? $this->providerTaxes->cuit : null;
        $qualification = $this->providerTaxes instanceof ProviderTaxes ? $this->providerTaxes->qualification : null;
        $province = $this->provinces->province;

        $response = str_replace("{year}", date('Y'), $response);
        $response = str_replace("{day}", date('d'), $response);
        $response = str_replace("{month}", $this->getMonth(date('m')), $response);
        $response = str_replace("{date}", date('Y/m/d'), $response);
        $response = str_replace("{datetime}", date('Y/m/d H:i:s'), $response);
        $response = str_replace("{time}", date('H:i:s'), $response);
        $response = str_replace("{responsableFirstName}", $responsableFirstName, $response);
        $response = str_replace("{responsableLastName}", $responsableLastName, $response);
        $response = str_replace("{responsableDni}", $responsableDni, $response);
        $response = str_replace("{configCommission}", $configCommission, $response);
        $response = str_replace("{qualification}", $qualification, $response);
        $response = str_replace("{cuit}", $cuit, $response);
        $response = str_replace("{province}", $province, $response);
        $response = str_replace("{feriameMail}", Yii::$app->params['contractEmail'], $response);

        return $response;
    }

    private function getMonth($month): string
    {
        $months = [
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Septiembre',
            'Octubre',
            'Noviembre',
            'Diciembre',
        ];

        return $months[$month - 1];
    }

    /**
     * @param Carbon $requestDate
     * @param array $attentionSchedule
     * @param $daysOfProduction
     * @return Carbon
     */
    private function getCollectionDate(Carbon $requestDate, array $attentionSchedule, $daysOfProduction, $holidays, &$fechaTakeAway)
    {
        $fechaCandidata = false;
        $yaTieneFechaDeElaboracion = false;
        $fechaDeLogistica = false;

        Yii::info(json_encode(
            [
                'method' => __METHOD__,
                'message' => 'Comienza algoritmo de collection date',
                'requestDate' => $requestDate->format('d/m/Y'),
                'attentionSchedule' => $attentionSchedule,
                'daysOfProduction' => $daysOfProduction
            ]
        ), 'general');

        while (!$fechaCandidata) {
            $nombreDia = $this->convertDayName(substr($requestDate->dayName, 0, 3));

            //CHEQUEO QUE NO ATIENDA ESE DIA PARA SUMAR UN DIA
            if (!in_array(strtolower($nombreDia), array_map('strtolower', $attentionSchedule))) {
                $requestDate->addDay();
                $nombreDia = $this->convertDayName(substr($requestDate->dayName, 0, 3));
                $fechaCandidata = false;
            }

            //CHEQUEO QUE ATIENDA Y LE SUMO LOS DIAS DE ELABORACION
            if (in_array(strtolower($nombreDia), array_map('strtolower', $attentionSchedule))) {
                if (!$yaTieneFechaDeElaboracion) {
                    $yaTieneFechaDeElaboracion = true;
                    $requestDate->addDays($daysOfProduction);
                }
                $fechaCandidata = true;
            }

            //CHEQUEO SI ES FIN DE SEMANA
            if ($this->checkLaboralDay($requestDate, $holidays)) {
                $fechaCandidata = false;
                $requestDate->addDay();
            }

            /**
             * logistica lo va a ir a buscar al proximo día habil que fué producido
             * fl = fc == false
             * !fl = fc == entrar al if
             * Agrego un día de logistica sino es takeaway
             */
            if (!$fechaDeLogistica && $fechaCandidata) {
                $fechaDeLogistica = true;
                $fechaTakeAway = clone $requestDate;
                $requestDate->addDay();
                $fechaCandidata = false;
            }

        }

        Yii::info(json_encode(
            [
                'method' => __METHOD__,
                'message' => 'Finaliza algoritmo de collection date',
                'finalDate' => $requestDate->format('d/m/Y'),
                'fechaTakeaway' => $fechaTakeAway->format('d/m/Y')
            ]
        ), 'general');

        return $requestDate;
    }

    /**
     * @param Carbon $collectionDate
     * @param array $holidays
     */
    private function getDeliveryDate(Carbon $collectionDate, array $holidays)
    {
        $fechaDelivery = false;
        $countFechaDelivery = false;
        //Dia de delivery
        while (!$fechaDelivery) {

            $fechaDelivery = true;

            //fecha de delivery logistica
            if (!$countFechaDelivery) {
                $collectionDate->addDay();
                $countFechaDelivery = true;
            }

            if ($this->checkLaboralDay($collectionDate, $holidays)) {
                $fechaDelivery = false;
                $collectionDate->addDay();
            }

            if ($fechaDelivery) {
                break;
            }
        }

        return $collectionDate->format('d/m/Y');
    }

    /**
     * @param Carbon $collectionDate
     * @param array $holidays
     */
    private function getNodesDeliveryDate(Carbon $nodeCollectionDate, array $holidays, $nodes)
    {
        Yii::info(
            json_encode([
                'method' => __METHOD__,
                'nodes' => $nodes
            ]),
            'general'
        );
        $nodesResult = [];
        foreach ($nodes as $node) {
            $fechaDelivery = false;
            $countFechaDelivery = false;

            $nodeDate = clone $nodeCollectionDate;

            $nodeWorkDays = json_decode($node->workDays);

            //Dia de retiro en nodo
            while (!$fechaDelivery) {

                $fechaDelivery = true;
                $nombreDia = $this->convertDayName(substr($nodeDate->dayName, 0, 3));

                //fecha de delivery logistica
                if (!$countFechaDelivery) {
                    $nodeDate->addDay();
                    $countFechaDelivery = true;
                    $nombreDia = $this->convertDayName(substr($nodeDate->dayName, 0, 3));
                }

                if ($this->checkLaboralDay($nodeDate, $holidays)) {
                    $fechaDelivery = false;
                    $nodeDate->addDay();
                    $nombreDia = $this->convertDayName(substr($nodeDate->dayName, 0, 3));
                }

                if (!$this->checkDayNodeIsOpen($nombreDia, $nodeWorkDays)) {
                    $fechaDelivery = false;
                    $nodeDate->addDay();
                    $nombreDia = $this->convertDayName(substr($nodeDate->dayName, 0, 3));
                }


                if ($this->checkDayNodeIsOpen($nombreDia, $nodeWorkDays)) {
                    break;
                }

                if ($fechaDelivery) {
                    break;
                }
            }

            $node->default = $node === reset($nodes);
            $node->available_date = $nodeDate->format('d/m/Y');

            $nodesResult[] = $node;
        }

        return $nodesResult;

    }

    /**
     * @param $nombreDia
     * @param $nodeWorkDays
     * @return bool
     */
    private function checkDayNodeIsOpen($nombreDia, $nodeWorkDays)
    {
        return in_array(strtolower($nombreDia), array_map(function ($item) {
            return strtolower(substr($item, 0, 3));
        }, $nodeWorkDays));
    }
}
