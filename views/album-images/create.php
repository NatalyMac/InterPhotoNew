<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AlbumImages */

$this->title = 'Create Album Images';
$this->params['breadcrumbs'][] = ['label' => 'Album Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="album-images-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
