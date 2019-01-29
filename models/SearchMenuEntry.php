<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchMenuEntry represents the model behind the search form of `app\models\Menuentry`.
 */
class SearchMenuEntry extends Menuentry
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'position', 'staff_id'], 'integer'],
            [['title', 'link', 'content'], 'safe'],
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
     * @param integer $id
     * @return ActiveDataProvider
     */
    public function search($params,$id)
    {
        $query = Menuentry::find()->where(['staff_id' => $id]);

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
            'position' => $this->position,
            'is_deleted' => $this->is_deleted,
            'staff_id' => $this->staff_id,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'link', $this->link])
            ->andFilterWhere(['ilike', 'content', $this->content]);

        return $dataProvider;
    }
}
