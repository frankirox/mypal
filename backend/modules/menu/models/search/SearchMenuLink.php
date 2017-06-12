<?php

namespace backend\modules\menu\models\search;

use common\models\MenuLink;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\helpers\MirandaHelper;
use common\models\interfaces\OwnerAccess;
use common\models\User;

/**
 * SearchMenuLink represents the model behind the search form about `common\models\MenuLink`.
 */
class SearchMenuLink extends MenuLink
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order', 'alwaysVisible', 'created_by', 'updated_by'], 'integer'],
            [['target'], 'string'],
            [['id', 'menu_id', 'parent_id', 'link', 'label', 'image', 'created_at', 'updated_at', 'target'], 'safe'],
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
    public function search($params = [])
    {
        $queryParams = Yii::$app->request->getQueryParams();
        $query = MenuLink::find()->joinWith('translations');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => -1,
            ],
            'sort' => [
                'defaultOrder' => [
                    'order' => SORT_ASC,
                ],
            ],
        ]);

        $this->load($queryParams);

        foreach ($params as $key => $value) {
            $this->$key = $value;
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andWhere(['menu_link.menu_id' => $this->menu_id])
            ->andFilterWhere(['alwaysVisible' => $this->alwaysVisible])
            ->andFilterWhere(['like', 'id', $this->id])
            ->andWhere(['parent_id' => $this->parent_id])
            ->andFilterWhere(['like', 'target', $this->target]);

        return $dataProvider;
    }
}