<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchStaff represents the model behind the search form of `app\models\User`.
 */
class SearchStaffAdmin extends User
{
	
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['username', 'password', 'authkey', 'name', 'surname'], 'safe'],
            [['is_disabled'], 'boolean'],
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
        $config = require __DIR__ . '/../config/web.php';
        $query = User::find()->leftjoin('auth_assignment', 'id::integer=user_id::integer')->where(['item_name' => 'staff'])->orWhere(['=','item_name','admin']);

        // add conditions that should always be applied here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $config['params']['page_size'],
            ],
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
            'is_disabled' => $this->is_disabled,
        ]);

        $query->andFilterWhere(['ilike', 'username', $this->username])
            ->andFilterWhere(['ilike', 'password', $this->password])
            ->andFilterWhere(['ilike', 'authkey', $this->authkey])
            ->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'surname', $this->surname]);

        return $dataProvider;
    }
	
}
