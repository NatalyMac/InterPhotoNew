<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AlbumImages;


class AlbumImagesSearch extends AlbumImages
{
    public function rules()
    {
        return [
            [['id', 'album_id'], 'integer'],
            [['image', 'created_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $queryImage = AlbumImages::find();

        $dataProviderIndex = new ActiveDataProvider([
            'query' => $queryImage,]);
        
        $this->attributes = $params;
        
        if (!$this->validate()) 
            {
                $query->where('0=1');
                    return $dataProvider;
            }
        if ($params['status'] == null)
        {
            $queryImage->andFilterWhere([
                //'id' => $this->id,
                'album_id' => $this->id,
                'created_at' => $this->created_at,
                ]);
            $queryImage->andFilterWhere([
                'like', 'image', $this->image]);

            return $dataProviderIndex;
        }
        
        if (([$params['status']] !== null)) 
            $status=$params['status'];
            /*
            {
                $this->status = $params['status'];
                $queryImage = \app\models\AlbumImages::find()
                   // ->with(['resizedPhotos'])
                    ->with(['resizedPhotos' => function($q) {
                                                       // $q->andWhere(['status' =>"new"]);}
                                $q->andWhere(['status' => $this->status]);
                                $q->select(['image_id', 'status']);}
                           ])
                    ->asArray();
                $dataProviderStatusIndex = new ActiveDataProvider(['query' => $queryImage]);
                   return $dataProviderStatusIndex;
            }
           */
            {
               /* $sql = "SELECT DISTINCT album_images.image, album_images.id, resized_photos.status 
                                   FROM album_images, resized_photos 
                                   WHERE album_images.id = resized_photos.image_id 
                                   AND resized_photos.status = '".$status."'";
                if (!mysql_real_escape_string($sql))
                    return false;*/

                $queryImage = AlbumImages::findBySql
                                 ("SELECT DISTINCT album_images.image, album_images.id, resized_photos.status 
                                   FROM album_images, resized_photos 
                                   WHERE album_images.id = resized_photos.image_id 
                                   AND resized_photos.status = '".$status."'")
                            ->asArray();
               
                $dataProviderStatusIndex = new ActiveDataProvider(['query' => $queryImage]);
                    return $dataProviderStatusIndex;
            }
    }


}
