<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchPages represents the model behind the search form of `app\models\Page`.
 */
class SearchPages extends Page
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'course_site'], 'integer'],
            [['title', 'content'], 'safe'],
            [['is_home', 'is_public', 'is_news'], 'boolean'],
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
     * @param integer $coursesite
     * @return ActiveDataProvider
     */
    public function search($params,$coursesite)
    {
        $query = Page::find()->where(['course_site' => $coursesite]);

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
            'is_home' => $this->is_home,
            'is_public' => $this->is_public,
            'is_news' => $this->is_news,
            'course_site' => $this->course_site,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'content', $this->content]);

        return $dataProvider;
    }
}
