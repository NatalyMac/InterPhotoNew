<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AlbumImages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="album-images-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'album_id')->textInput() ?>

    <?= $form->field($model, 'image')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
