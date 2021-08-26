<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Qualifications;
use app\models\QualificationLikes;

/**
 * QualificationsSearch represents the model behind the search form of `app\models\Qualifications`.
 */
class QualificationsSearch extends Qualifications
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'purchases_id'], 'integer'],
            [['liked', 'title','product_score','delivery_score','provider_score','updated_at','deleted_at','created_at','comment'], 'safe'],
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
        $query = QualificationLikes::find()->joinWith([
            'purchase',
            'qualificationVote'
        ]);

        // var_dump($query->createCommand()->getRawSql());die;
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
