<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Subscribes */
/* @var $exam app\models\Exam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subscribes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'student')->widget(\kartik\select2\Select2::className(),[
        'data' => ArrayHelper::map(User::find()->leftjoin('auth_assignment', 'id::integer=user_id::integer')->where(['item_name' => 'student'])->all(), 'id', 'username'),
        'language' => 'it',
        'options' => ['placeholder' => 'Select a student ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?>
    <!-- exam has already been decided -->
    <?= $form->field($model, 'exam')->textInput(['readonly' => true, 'value' => $exam]) ?>

    <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::className(), []);?>

    <?= $form->field($model, 'result')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
