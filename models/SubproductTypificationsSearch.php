<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SubproductTypifications;

/**
 * SubproductTypificationsSearch represents the model behind the search form of `app\models\SubproductTypifications`.
 */
class SubproductTypificationsSearch extends SubproductTypifications
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'active', 'subproduct_types_id'], 'integer'],
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
        $query = SubproductTypifications::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $this->load($params,'');

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
