<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchExam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="exam-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'opening_date') ?>

    <?= $form->field($model, 'closing_date') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'info') ?>

    <?php // echo $form->field($model, 'course') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
