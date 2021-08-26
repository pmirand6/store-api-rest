<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SubproductTypes;

/**
 * SubproductTypeSearch represents the model behind the search form of `app\models\SubproductTypes`.
 */
class SubproductTypesSearch extends SubproductTypes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'active', 'product_types_id'], 'integer'],
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
        $query = SubproductTypes::find();
        $query->alias('sp');
        $query->distinct();

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
                if (isset($value['like']) && $value['like']) {
                    $query->andFilterWhere(['like', "sp.{$key}", $value['like']]);
                } else {
                    if ($this->isFromCreateProducts($params, $key, $value)) {
                        $query->andFilterWhere(["{$key}" => $value]);
                    } else {
                        $query->innerJoin('products p', 'p.subproduct_types_id = sp.id');
                        $query->innerJoin('product_types pt', 'pt.id = sp.product_types_id');
                        $query->where(['p.status' => 'habilitado']);
                        $query->andFilterWhere(["sp.{$key}" => $value]);
                    }
                }

            }
        }

        return $dataProvider;
    }

    // Method to determines if request cames from Alta de Producto
    private function isFromCreateProducts($params, $key, $value): bool
    {
        return $value && !(is_array($value)) && $key == 'product_types_id' && isset($params['sort']) && $params['sort'];
    }
}
