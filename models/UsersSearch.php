<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Users;
//use yii\web\BadRequestHttpException;

class UsersSearch extends Users
{
    public function rules()
        {
            return [
                [['id'], 'integer'],
                [['access_token', 'role', 'name', 'email', 'password', 'phone', 'modified_at', 'created_at', 'auth_key', 'password_hash'], 'safe'],
              ];
        }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $this->load($params);
        if (!$this->validate()) 
            {
                $query->where('0=1');
                return $dataProvider;
            }
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
