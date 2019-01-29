<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchFile represents the model behind the search form of `app\models\File`.
 */
class SearchFile extends File
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'course_site'], 'integer'],
            [['title'], 'safe'],
            [['is_public'], 'boolean'],
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
     * @param integer $courseSite
     * @return ActiveDataProvider
     */
    public function search($params,$courseSite)
    {
        $query = File::find()->where(['course_site' => $courseSite]);

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
            'is_public' => $this->is_public,
            'course_site' => $this->course_site,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title]);

        return $dataProvider;
    }
}
