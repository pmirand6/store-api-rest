<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Products;
use app\models\SearchLogs;

/**
 * ProductsSearch represents the model behind the search form of `app\models\Products`.
 */
class ProductsSearch extends Products
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'active'], 'integer'],
            [['name', 'alias', 'languages_lang', 'created_at', 'updated_at'], 'safe'],
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
        // Registro SearchLogs
        SearchLogs::create($params);

        $query = $this->find()->joinWith([
            'productTypes',
            'subproductTypes',
            'subproductTypifications',
            'favorites',
            'providers',
            'productsHasDeliveryTypes',
            'productsHasDeliveryTypes.deliveryType'
        ]);


        // Solo mostrar productos de proveedores con mercado pago
        $query->andWhere(['not', ['providers.mercadopago_id' => NULL]]);

        $query->andWhere(['products.status' => 'habilitado', 'products.active' => 1]);
        $query->andWhere(['>', 'stock', 0]);
        $query->andWhere('
            `products`.`expires` = 0 
            OR `products`.`expires` = 1 
            and datediff(NOW(), IFNULL(`products`.`updated_at`, `products`.`created_at`)) < `products`.`expires_time`'
        );
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => isset($params['pageSize']) ? $params['pageSize'] : 20,
                'validatePage' => false,
            ],
        ]);

        $this->load($params,'');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return ['data' => $dataProvider, 'total' => $query->groupBy(['products.id'])->count()];
        }

        $likeFilter = [];

        if(isset($params['filter']))
        {
            foreach ($params['filter'] as $key => $value)
            {
                if(isset($value['like']))
                {
                    $likeFilter[] = ['like', "$key", $value['like'] ];
                    // $query->orFilterWhere(['like', "$key", $value['like'] ]);
                }
                else{
                    if($key === 'favorites') {
                        $query->andWhere(['not', ['favorites.id' => null]]);
                    } else {
                        $query->andFilterWhere(["$key" => $value]);
                    }
                }
                
            }
        }

        if(count($likeFilter) > 0) {
            $andWhere = [];
            array_push($andWhere, 'or');

            foreach ($likeFilter as $key => $value) {
                array_push($andWhere, $value);
            }

            $query->andWhere($andWhere);
        }

        // Order
        if(isset($params['orderBy']))
        {
            $orderBy = [];
            
            foreach ($params['orderBy'] as $key => $value) {
                $orderBy[$key] = constant($value);
            }

            $query->orderBy($orderBy);
        }
        
        return ['data' => $dataProvider, 'total' => $query->groupBy(['products.id'])->count()];
    }

}
