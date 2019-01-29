<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchCourseSite represents the model behind the search form of `app\models\CourseSite`.
 */
class SearchCourseSite extends CourseSite
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'course'], 'integer'],
            [['title', 'edition', 'opening_date', 'closing_date', 'css'], 'safe'],
            [['is_current'], 'boolean'],
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
        $role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
        if(isset($role['admin'])) {
            $query = CourseSite::find()->where(['course' => $course]);
        }
        else {
            $query = CourseSite::find()->leftjoin('handles', '"course_site"."course"::integer="handles"."course"::integer')->where(['staff' => Yii::$app->user->identity->getId()])->orderBy(['is_current' => SORT_DESC]);

        }

        // add conditions that should always be applied here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you don't want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'opening_date' => $this->opening_date,
            'closing_date' => $this->closing_date,
            'is_current' => $this->is_current,
            'course' => $this->course,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'edition', $this->edition])
            ->andFilterWhere(['ilike', 'css', $this->css]);

        return $dataProvider;
    }
}
