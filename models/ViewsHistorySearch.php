<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ViewsHistory;
use app\apis\Auth;

/**
 * ViewsHistorySearch represents the model behind the search form of `app\models\ViewsHistory`.
 */
class ViewsHistorySearch extends ViewsHistory
{

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
        $query = ViewsHistory::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => !isset($params['limit']) ? 
                                [
                                    'pageSize' => isset($params['pageSize']) ? $params['pageSize'] : 20,
                                    'validatePage' => false,
                                ] 
                            : false,
        ]);

        $this->load($params,'');

        if (!$this->validate()) {
            // return ['data' => $dataProvider, 'total' => $dataProvider->getTotalCount()];
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

        if(isset($params['select'])){
            $query->addSelect($params['select']);
        }
        
        if(isset($params['with'])){
            $query->joinWith($params['with']);
        }

        if(isset($params['dateBetween']))
        {
            $query->andFilterWhere(['between', 'date', $params['dateBetween']['from'], $params['dateBetween']['to']]);
        }

        // Group
        if(isset($params['groupBy']))
        {
            $query->addSelect($params['groupBy']);
            $query->groupBy($params['groupBy']);
        }

        // Order
        if(isset($params['orderBy']))
        {
            if (isset($params['orderBy']['date'])){
                $query->orderBy( $params['orderBy']['date'] );
            }
        }

        // Limit
        if(isset($params['limit'])){
            $query->limit( $params['limit'] );
        }
        
        return ['data' => $dataProvider, 'total' => $dataProvider->getTotalCount()];
    }
}
