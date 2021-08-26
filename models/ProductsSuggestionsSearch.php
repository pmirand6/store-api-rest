<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Products;
use app\models\SearchLogs;
use app\models\ViewsHistory;

/**
 * ProductsSearch represents the model behind the search form of `app\models\Products`.
 */
class ProductsSuggestionsSearch extends ProductsScored
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
    public function search($params, int $clients_id)
    {
        $productExample = ViewsHistory::find(['clients_id' => $clients_id])
            ->joinWith([ 'product', 'product.providers' ])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        if( !($productExample instanceof ViewsHistory) ) {
            return ['data' => [], 'total' => 0];
        }

        $query = $this->find()->joinWith([
            'productTypes',
            'subproductTypes',
            'subproductTypifications',
            'viewsHistory',
            'providers',
        ]);

        // Solo mostrar productos de proveedores con mercado pago
        $query->andWhere(['not', ['providers.mercadopago_id' => NULL]]);

        $query->andWhere(['products_scored.status' => 'habilitado', 'products_scored.active' => 1]);
        $query->andWhere(['>', 'stock', 0]);
        $query->andWhere('
            `products_scored`.`expires` = 0 
            OR `products_scored`.`expires` = 1 
            and datediff(NOW(), IFNULL(`products_scored`.`updated_at`, `products_scored`.`created_at`)) < `products_scored`.`expires_time`'
        );

        $query->andWhere(['or',
            ['product_types.id' => $productExample->product->product_types_id],
            ['subproduct_types.id' => $productExample->product->subproduct_types_id],
            ['subproduct_typifications.id' => $productExample->product->subproduct_typifications_id]
        ]);

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
            return ['data' => $dataProvider, 'total' => $query->groupBy('products_scored.id')->count()];
        }

        if(isset($params['filter']))
        {
            foreach ($params['filter'] as $key => $value)
            {
                if(isset($value['like']))
                {
                    $query->orFilterWhere(['like', "$key", $value['like'] ]);
                }
                else{
                    $query->andFilterWhere(["$key" => $value]);
                }
                
            }
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
        
        return ['data' => $dataProvider, 'total' => $query->groupBy('products_scored.id')->count()];
    }
}
