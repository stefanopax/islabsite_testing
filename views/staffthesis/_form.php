<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Thesis */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="thesis-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'duration')->textInput() ?>

    <?= $form->field($model, 'requirements')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'course')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'n_person')->textInput() ?>

    <?= $form->field($model, 'ref_person')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_visible')->checkbox() ?>

    <?= $form->field($model, 'trien')->checkbox() ?>

    <?= $form->field($model, 'staff')->hiddenInput(['value'=> Yii::$app->user->identity->getId()])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
