<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchSubscribes represents the model behind the search form of `app\models\Subscribes`.
 */
class SearchSubscribes extends Subscribes
{

    public $register_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['exam'], 'integer'],
            [['date', 'result','register_id','student'], 'safe'],
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
     * @param integer $exam
     * @return ActiveDataProvider
     */
    public function search($params,$exam)
    {
        $query = Subscribes::find()->leftJoin('user','student = id')->where(['exam' => $exam])->orderBy('surname');

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

        $query->leftjoin('student', '"subscribes"."student" = "student"."id"');

        // grid filtering conditions
        $query->andFilterWhere([
            'exam' => $this->exam,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['ilike', 'result', $this->result])
            ->andFilterWhere(['ilike', 'CAST(register_id as VARCHAR(50))', $this->student]);

        return $dataProvider;
    }
}
