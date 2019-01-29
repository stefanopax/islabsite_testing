<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchProject represents the model behind the search form of `app\models\Project`.
 */
class SearchProject extends Project
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at'], 'integer'],
            [['title', 'description', 'link', 'image'], 'safe'],
            [['is_deleted'], 'boolean'],
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
        $query = Project::find()->where(['is_deleted' => false])->orderBy(['created_at'=>SORT_ASC]);

        // add conditions that should always be applied here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if(!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'description', $this->description])
            ->andFilterWhere(['ilike', 'link', $this->link])
            ->andFilterWhere(['ilike', 'image', $this->image]);

        return $dataProvider;
    }
}
