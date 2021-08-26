<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Questions;

/**
 * QuestionsSearch represents the model behind the search form of `app\models\Questions`.
 */
class QuestionsSearch extends Questions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'products_id'], 'integer'],
            [['questioned_at', 'answered_at', 'deleted_at','question', 'answer'], 'safe'],
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
        $query = Questions::find();
        // ->joinWith([
        //     // 'products',
        // ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => isset($params['pageSize']) ? $params['pageSize'] : 20,
                'validatePage' => false,
            ],
        ]);

        $this->load($params,'');

        if (!$this->validate()) {
            return ['data' => $dataProvider, 'total' => $dataProvider->getTotalCount()];
        }

        $likeFilter = [];

        if(isset($params['filter']))
        {
            foreach ($params['filter'] as $key => $value)
            {
                if(isset($value['like']))
                {
                    $likeFilter[] = ['like', "$key", $value['like'] ];
                }
                else{
                    $query->andFilterWhere(["$key" => $value]);
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
        
        return ['data' => $dataProvider, 'total' => $dataProvider->getTotalCount()];
    }

}
