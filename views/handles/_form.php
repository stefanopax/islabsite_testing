<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use yii\helpers\ArrayHelper;
use app\models\Course;

/* @var $this yii\web\View */
/* @var $model app\models\Handles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="handles-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'staff')->widget(\kartik\select2\Select2::className(),[
        'data' => ArrayHelper::map(User::find()->leftjoin('auth_assignment', 'id::integer=user_id::integer')->where(['<>','item_name','student'])->all(), 'id', 'username'),
        'language' => 'it',
        'options' => ['placeholder' => 'Select a user ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?>

    <?= $form->field($model, 'course')->widget(\kartik\select2\Select2::className(),[
        'data' => ArrayHelper::map(Course::find()->all(), 'id', 'title'),
        'language' => 'it',
        'options' => ['placeholder' => 'Select course ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
