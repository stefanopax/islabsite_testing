<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchExam represents the model behind the search form of `app\models\Exam`.
 */
class SearchExam extends Exam
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'course'], 'integer'],
            [['title', 'date', 'opening_date', 'closing_date', 'type', 'info'], 'safe'],
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
            $query = Exam::find();
        }
        else {
            $query = Exam::find()->leftjoin('handles', '"exam"."course" = "handles"."course"')->where(['"handles"."staff"' => Yii::$app->user->identity->getId()]);
        }
        // add conditions that should always be applied here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
            'opening_date' => $this->opening_date,
            'closing_date' => $this->closing_date,
            'course' => $this->course,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'type', $this->type])
            ->andFilterWhere(['ilike', 'info', $this->info]);

        return $dataProvider;
    }
}
