<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Addresses;

/**
 * AddressesSearch represents the model behind the search form of `app\models\Addresses`.
 */
class AddressesSearch extends Addresses
{
    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            'id',
            'postal_code',
            'address',
            'street_number',
            'formatted_address',
            'latitude',
            'longitude',
            'clients_id',
            'created_at',
            'deleted_at',
            'updated_at',
            'principal',
            'principal',
            'name',
            'floor',
            'department',
            'reference',
            'localities_id',
            'provinces_id'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [
                [ 
                    'postal_code',
                    'address',
                    'street_number',
                    'formatted_address',
                    'latitude',
                    'longitude',
                    'clients_id',
                    'created_at',
                    'deleted_at',
                    'updated_at',
                    'principal',
                    'principal',
                    'name',
                    'floor',
                    'department',
                    'reference',
                    'localities_id',
                    'provinces_id'
                ], 'safe'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->andWhere(['deleted_at' => null]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if(isset($params['filter']))
        {
            foreach ($params['filter'] as $key => $value)
            {
                if(isset($value['like']))
                {
                    $query->andFilterWhere(['like', "$key", $value['like'] ]);
                }
                else{
                    $query->andFilterWhere(["$key" => $value]);
                }
                
            }
        }

        return $dataProvider;
    }
}
