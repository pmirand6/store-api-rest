<?php

namespace app\models;

use app\apis\facturacion\BillingParametersFacturacion;
use Yii;

/**
 * This is the model class for table "billing_parameters".
 *
 * @property int $id
 * @property string $mercado_pago_rsn
 * @property string $mercado_pago_alitaware
 * @property float $commission_percent
 * @property float $iva_percent
 * @property float $commission_percent_rsn
 * @property float $commission_percent_alitaware
 * @property float $cost_until_20kg
 * @property float $cost_higher_20kg
 * @property float $cost_per_km_until_20kg
 * @property float $cost_per_km_higher_20kg
 * @property string $url_api_rsn
 * @property string $url_api_alitaware
 * @property string $user
 * @property string $password
 * @property string $client_id
 * @property string $secret_key
 * @property string $company
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string $email_admin_rsn
 */
class BillingParameters extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'billing_parameters';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['commission_percent', 'iva_percent', 'commission_percent_rsn', 'commission_percent_alitaware', 'cost_until_20kg', 'cost_higher_20kg', 'cost_per_km_until_20kg', 'cost_per_km_higher_20kg'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['mercado_pago_rsn', 'mercado_pago_alitaware', 'company'], 'string', 'max' => 128],
            [['url_api_rsn', 'url_api_alitaware', 'user', 'password', 'client_id', 'secret_key', 'email_admin_rsn'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mercado_pago_rsn' => 'Mercado Pago Rsn',
            'mercado_pago_alitaware' => 'Mercado Pago Alitaware',
            'commission_percent' => 'Commission Percent',
            'iva_percent' => 'Iva Percent',
            'commission_percent_rsn' => 'Commission Percent Rsn',
            'commission_percent_alitaware' => 'Commission Percent Alitaware',
            'cost_until_20kg' => 'Cost Until 20kg',
            'cost_higher_20kg' => 'Cost Higher 20kg',
            'cost_per_km_until_20kg' => 'Cost Per Km Until 20kg',
            'cost_per_km_higher_20kg' => 'Cost Per Km Higher 20kg',
            'url_api_rsn' => 'Url Api Rsn',
            'url_api_alitaware' => 'Url Api Alitaware',
            'user' => 'User',
            'password' => 'Password',
            'client_id' => 'Client ID',
            'secret_key' => 'Secret Key',
            'company' => 'Company',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'email_admin_rsn' => 'Email Admin RSN',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        try {
            $bodyParams = Yii::$app->getRequest()->getBodyParams();
            $response = (new BillingParametersFacturacion())->create($bodyParams);
            var_dump($response);
        }catch (\Throwable $th){
            throw new \Exception($th);
        }
    }

    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        
        // Update date
        if(!$insert) {
            $this->updated_at = date('Y-m-d H:i:s', strtotime('NOW'));
        }

        return parent::beforeSave($insert);
    }
}
