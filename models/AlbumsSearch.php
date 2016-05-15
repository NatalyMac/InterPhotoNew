<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AlbumsSearch represents the model behind the search form about `app\models\Albums`.
 */
class AlbumsSearch extends Albums
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'active'], 'integer'],
            [['name', 'created_at', 'modified_at'], 'safe'],
            [['id', 'user_id', 'active'], 'safe'],
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
        $cache = Yii::$app->cache;
        $key = md5(serialize($params));
        if ($cache->get($key)) {
            $query = $cache->get($key);
        } else {
            $query = Albums::find();
            $cache->set($key, $query);
        }


        $dataProvider = new ActiveDataProvider(['query' => $query,]);
        $this->attributes = $params;

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $id = \Yii::$app->user->identity->id;

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        if (array_key_exists('albums', $params)) {
            $albums = $this->getClientAlbums($id);

        }

        if (isset($albums) and count($albums) !== 0)
            $query->andFilterWhere(['in', 'id', $albums]);


        if (isset($albums) and count($albums) === 0) {

            $query->where('0=1');
        }
        return $dataProvider;
    }

}


