<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 20]) ?>

    <?= $form->field($model, 'is_home')->checkbox() ?>

    <?= $form->field($model, 'is_public')->checkbox() ?>

    <?= $form->field($model, 'is_news')->checkbox() ?>

    <?= $form->field($model, 'course_site')->widget(\kartik\select2\Select2::className(),[
        'data' => $data,
        'language' => 'it',
        'options' => ['placeholder' => 'Select a Course ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
