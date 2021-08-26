<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Providers;

/**
 * ProvidersSearch represents the model behind the search form of `app\models\Providers`.
 */
class ProvidersSearch extends Providers
{
    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            'id',
            'name',
            'business_name',
            'clasification',
            'latitude',
            'longitude',
            'floor',
            'department_number',
            'training',
            'logo',
            'phone_number',
            'email',
            'participate_fairs',
            'signature',
            'signature_date',
            'active',
            'created_at',
            'deleted_at',
            'updated_at',
            'users_id',
            'provider_types_id',
            'localities_id',
            'videos',
            'dni',
            'postal_code',
            'address',
            'street_number',
            'formatted_address',
            'mercadopago_id',
            'provinces_id',
            'localities_id'
        ];
    }
}
