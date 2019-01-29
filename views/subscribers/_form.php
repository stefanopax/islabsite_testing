<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Subscribes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subscribes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::className(), []);?>

    <?= $form->field($model, 'result')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
