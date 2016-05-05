<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Albums;

class AlbumsSearch extends Albums
{

    
    public function rules()
    {
        return [
            [['id', 'user_id', 'active'], 'integer'],
            [['name', 'created_at', 'modified_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    
    public function search($params)
    {
        $cache = Yii::$app->cache;
        $key = md5(serialize($params));
        if ($cache->get($key)) 
            {
                $query = $cache->get($key);
        } else {
            $query = Albums::find();
            $cache->set($key, $query);
        }
        

        $dataProvider = new ActiveDataProvider(['query' => $query,]);

        $this->load($params);

        if (!$this->validate()) 
        {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1'); 
            return $dataProvider;
        }

        $id = \Yii::$app->user->identity->id;
        if (array_key_exists('albums', $params['AlbumsSearch']))
            $albums = $this -> getClientAlbums($id);

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
      
        if (isset($albums))
            $query->andFilterWhere(['in', 'id', $albums]);
            
            return $dataProvider;
    }
}


