<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProductTypes;

/**
 * ProductTypesSearch represents the model behind the search form of `app\models\ProductTypes`.
 */
class ProductTypesSearch extends ProductTypes
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
        $query = ProductTypes::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, '');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (isset($params['filter'])) {
            foreach ($params['filter'] as $key => $value) {
                if (isset($value['like']) && $value['like'])  {
                    $query->andFilterWhere(['like', "$key", $value['like']]);
                } elseif(isset($value['name'])) {
                    $query->andFilterWhere(["$key" => $value]);
                } else {
                    $query->innerJoin('products', 'products.product_types_id = product_types.id');
                    $query->where(['products.status' => 'habilitado']);
                    $query->distinct();
                }

            }
        }


        return $dataProvider;
    }
}
