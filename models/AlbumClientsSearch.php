<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AlbumClients;

/**
 * AlbumClientsSearch represents the model behind the search form about `app\models\AlbumClients`.
 */
class AlbumClientsSearch extends AlbumClients
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'album_id', 'user_id'], 'integer'],
            [['access', 'created_at'], 'safe'],
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
        $query = AlbumClients::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'album_id' => $this->album_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'access', $this->access]);

        $id =  \Yii::$app->user->identity->id;
        
        if (array_key_exists('albums', $params))
        {
            $albums = $this -> getPhotographerAlbums($id);
            
        }
       
        if (isset($albums) and count($albums) !== 0)
            $query->andFilterWhere(['in', 'album_id', $albums]);
    
       
        if (isset($albums) and count($albums) === 0)
        {
      
           $query->where('0=1');
         }   
            return $dataProvider;
            
    }
}


