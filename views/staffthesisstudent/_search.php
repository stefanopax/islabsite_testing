<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchRequest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="request-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'thesis') ?>

    <?= $form->field($model, 'student') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'confirmed_at')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
