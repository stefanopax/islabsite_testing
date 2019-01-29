<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchHandles represents the model behind the search form of `app\models\Handles`.
 */
class SearchHandles extends Handles
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff', 'course'], 'integer'],
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
     * @param integer $course
     * @return ActiveDataProvider
     */
    public function search($params,$course)
    {
        $query = Handles::find()->where(['course' => $course]);

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
            'staff' => $this->staff,
            'course' => $this->course,
        ]);

        return $dataProvider;
    }
}
