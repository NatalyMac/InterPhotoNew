<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UsersSearch represents the model behind the search form about `app\models\Users`.
 */
class UsersSearch extends Users
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['access_token', 'role', 'name', 'email', 'password', 'phone', 'modified_at', 'created_at', 'auth_key', 'password_hash'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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

        $this->attributes = $params;
        $query = static::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);

        $query->andFilterWhere([
            'id' => $this->id,
            'modified_at' => $this->modified_at,
            'created_at' => $this->created_at,
        ]);

        $query
            ->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}
