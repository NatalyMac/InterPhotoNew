<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Users;
use yii\web\BadRequestHttpException;

class UsersSearch extends Users
{
    public function rules()
        {
            return [
                [['id'], 'integer'],
                [['access_token', 'role', 'name', 'username', 'password', 'phone', 'modified_at', 'created_at', 'auth_key', 'password_hash'], 'safe'],
              ];
        }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Users::find();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        
        $query->andFilterWhere([
            'id' => $this->id,
            'modified_at' => $this->modified_at,
            'created_at' => $this->created_at,
        ]);

        $query
            ->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'phone', $this->phone]);
            
            return $dataProvider;
    }
}
