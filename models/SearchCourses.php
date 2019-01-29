<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchCourses represents the model behind the search form of `app\models\Course`.
 */
class SearchCourses extends Course
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title'], 'safe'],
            [['is_active'], 'boolean'],
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
        $role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
        if(isset($role['admin'])) {
            $query = Course::find();
        }
        else {
            $query = Course::find()->joinWith('handles')->where(['"handles"."staff"' => Yii::$app->user->identity->getId()]);
        }

        // add conditions that should always be applied here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if(!$this->validate()) {
            // uncomment the following line if you don't want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title]);

        return $dataProvider;
    }
}
