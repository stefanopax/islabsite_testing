<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Request */
/* @var $thesis app\models\Student */
/* @var $stud app\models\Thesis */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="request-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($thesis, 'title')->textInput(['readonly' => true]) ?>

    <?= $form->field($stud, 'username')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'confirmed_at')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
