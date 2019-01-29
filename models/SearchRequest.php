<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchRequest represents the model behind the search form of `app\models\Request`.
 */
class SearchRequest extends Request
{
    public $register_id;
    public $thesis;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['thesis','student'], 'integer'],
            [['title','student','thesis','register_id','thesis'], 'safe'],
            [['confirmed_at'], 'boolean'],
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
            $query = Request::find()->joinWith('thesis0');
        }
        else {
            $query = Request::find()->joinWith('thesis0')->where(['thesis.staff' => Yii::$app->user->identity->getId()]);
        }

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

        $query->joinWith('student0');
		
        // grid filtering conditions
        $query->andFilterWhere([
            'thesis' => $this->thesis,
            'created_at' => $this->created_at,
            'confirmed_at' => $this->confirmed_at,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike','register_id', $this->student]);

        return $dataProvider;
    }
}
