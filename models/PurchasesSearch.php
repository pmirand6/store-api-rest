<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Purchases;

/**
 * PurchasesSearch represents the model behind the search form of `app\models\Purchases`.
 */
class PurchasesSearch extends Purchases
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['quantity', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
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
            'product',
            'client',
        ]);
        
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
            return ['data' => $dataProvider, 'total' => $dataProvider->getTotalCount()];
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
        
        return ['data' => $dataProvider, 'total' => $dataProvider->getTotalCount()];
    }
}
