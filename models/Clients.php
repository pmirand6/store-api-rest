<?php

namespace app\models;

use Yii;
use app\apis\Auth;
use app\apis\Auth0Management;
use app\actions\contracts\GetLastContractAction;
use kartik\mpdf\Pdf;
use app\models\Addresses;

/**
 * This is the model class for table "clients".
 *
 * @property int $id
 * @property string $created_at
 * @property string|null $deleted_at
 * @property string $updated_at
 * @property int|null $active
 * @property string|null $birth_date
 * @property float|null $dni
 * @property string|null $gender
 * @property string|null $name
 * @property int $users_id
 *
 * @property Users $users
 */
class Clients extends \yii\db\ActiveRecord
{
    public $legalPath = "../web/legal/clients/";
    public $picturePath = "../web/pictures/clients/";

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dni'], 'required'],
            [['created_at', 'deleted_at', 'updated_at', 'birth_date', 'signature_date'], 'safe'],
            [['active', 'users_id', 'dni'], 'integer'],
            [['signature'], 'boolean'],
            [['phone_number'], 'number'],
            [['gender', 'name', 'avatar', 'picture', 'lastname', 'image_preference', 'phone_prefix'], 'string'],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['users_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'deleted_at' => 'Deleted At',
            'updated_at' => 'Updated At',
            'active' => 'Active',
            'birth_date' => 'Birth Date',
            'dni' => 'Dni',
            'gender' => 'Gender',
            'users_id' => 'Users ID',
            'signature' => 'Signature',
            'signature_date' => 'Signature Date',
            'name' => 'Name',
            'lastname' => 'Last Name',
            'phone_number' => 'Phone Number',
            'phone_prefix' => 'Phone Prefix',
            'avatar' => 'Avatar',
            'picture' => 'Picture',
        ];
    }

    /**
     * Gets avatars
     */
    public static function avatars()
    {
        return [
            'VASI',
            'CAMI',
            'CANNY',
            'MANZI',
            'FELPI',
            'DULCE',
        ];
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
     * Gets query for [[ClientHasInterestGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientHasInterestGroups()
    {
        return $this->hasMany(ClientHasInterestGroups::className(), ['clients_id' => 'id']);
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

    /**
     * Gets query for [[Addresses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(AddressesSearch::className(), ['clients_id' => 'id'])->onCondition('addresses.deleted_at IS NULL');
    }

    public function extraFields()
    {
        return [
            'clientHasInterestGroups',
            'addresses'
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

        // set random avatar
        if ($insert) {
            $this->avatar = array_rand(Clients::avatars());
        }

        if ($this->signature && $insert) {
            // Signature first contract
            $contract = Contracts::getLastContract(Contracts::TYPE_CLIENT);
            $this->contracts_id = $contract ? $contract->id : null;
            $this->signature_date = date('Y-m-d');
        }

        $oldModel = self::findOne($this->id);
        if ($oldModel && !$oldModel->signature && $this->signature) {
            $contract = Contracts::getLastContract(Contracts::TYPE_CLIENT);
            $this->contracts_id = $contract ? $contract->id : null;

            $this->signature_date = date('Y-m-d');
        }

        try {
            //Trabajamos los datos de usuario: 
            if ($this->isNewRecord) {
                $auth = Auth::instance();
                $authUser = $auth->getUser(true);

                if ($authUser) {
                    if ($authUser->client) {
                        throw new \Error('El usuario ya se encuentra registrado como cliente.');
                    }

                    $user = $authUser;
                } else {
                    $user = new Users;
                    $userInfo = $auth->getUserInfo();
                    $user->email = $userInfo ? $userInfo->email : null;

                    if (!$user->save()) {
                        return false;
                    }
                }

                $auth0Management = new Auth0Management();
                $auth0Management->assignUserToRole($auth->getTokenInfo()['sub'], 'Cliente');

                if (Clients::find()->where(['users_id' => $user->id])->exists()) {
                    return false;
                }

                $this->users_id = $user->id;
            }

            return parent::beforeSave($insert);
        } catch (Exeption $e) {
            throw new \yii\web\NotFoundHttpException;
        }
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
     * Envio de mail a cliente con ofertas similares a su última búsqueda realizada.
     * TO-DO: Maquetado de mail
     *
     * @param array $offers
     */
    public function sendOffersMail($offers)
    {
        if ($offers) {
            Yii::$app->mailer->compose('clients/sendOffers', [
                'offers' => $offers,
                'imageUrl' => Yii::$app->params['url'] . "/mailing/images/"
            ])
                ->setFrom(Yii::$app->params['infoEmail'])
                ->setTo($this->users->email)
                ->setSubject('Feriame.com | Productos Similares')
                ->send();

            $log = ["client_id" => $this->id, "offers_sent" => count($offers)];
            return json_encode($log);
        }
    }


    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {

            // Save Address
            $address = new Addresses();
            $address->load(Yii::$app->getRequest()->getBodyParams(), '');
            $address->clients_id = $this->id;
            $address->save();

            if ($this->signature) {
                $this->logSignature();
                $this->sendContract();
            }
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
        $log = new ClientSignatureHistory();
        $log->clients_id = $this->id;
        $log->ip = Yii::$app->request->getRemoteIP();
        $log->user_agent = Yii::$app->request->getUserAgent();

        $log->save();
    }

    public function sendContract()
    {
        $content = $this->replaceMacros($this->contract->contract);

        $pdf = new Pdf([
            'filename' => $this->user->email . '-client-legal-signature-' . date('Y-m-d_H:i:s') . '.pdf',
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
            'options' => ['title' => 'Feriame.com - Contract Client - ' . $this->user->email],
        ]);

        $path = $this->legalPath . $this->user->email . '/';

        // check if exist legal path for provider
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $pdf->output($content, $path . $pdf->filename, Pdf::DEST_FILE);


        Yii::$app->mailer->compose('clients/signature', [
            'client' => $this,
            'imageUrl' => Yii::$app->params['url'] . "/mailing/images/"
        ])
            ->setFrom('info@feriame.com')
            ->setTo($this->user->email)
            ->setSubject('Feriame.com | Términos y condiciones de Feriame')
            ->attach($path . $pdf->filename)
            ->send();
    }

    public function replaceMacros($text): ?string
    {
        $response = $text;
        foreach ($this->getAttributes() as $attribute => $value) {
            $response = str_replace('{' . $attribute . '}', $value, $response);
        }

        $response = str_replace("{date}", date('Y/m/d'), $response);
        $response = str_replace("{datetime}", date('Y/m/d H:i:s'), $response);
        $response = str_replace("{time}", date('H:i:s'), $response);

        return $response;
    }

    public function getPrincipalAddress(): ?string
    {
        $address = Addresses::findOne(['clients_id' => $this->id, 'principal' => true]);

        return $address instanceof Addresses ? $address->getFullAddress() : '';
    }

    public function getPrincipalAddressModel()
    {
        return Addresses::find()
            ->where(['clients_id' => $this->id])
            ->andWhere(['principal' => true])
            ->orderBy(['created_at' => SORT_DESC])
            ->one();
    }
}
