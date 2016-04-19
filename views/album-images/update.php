<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AlbumImages */

$this->title = 'Update Album Images: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Album Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="album-images-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
