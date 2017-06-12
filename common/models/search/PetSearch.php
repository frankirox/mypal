<?php

namespace common\models\search;

use common\models\Pet;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PostSearch represents the model behind the search form about `common\models\Post`.
 */
class PetSearch extends Pet
{

    public $sold_at_operand;
    public $created_at_operand;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'age','status'], 'integer'],
            [['sold_at_operand', 'created_at_operand', 'breed', 'name', 'age', 'sold_at', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Pet::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'age' => $this->age,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere([($this->sold_at_operand) ? $this->sold_at_operand : '=', 'sold_at', ($this->sold_at) ? strtotime($this->sold_at) : null]);
        $query->andFilterWhere([($this->created_at_operand) ? $this->created_at_operand : '=', 'created_at', ($this->created_at) ? strtotime($this->created_at) : null]);


        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'breed', $this->breed]);

        return $dataProvider;
    }

}
