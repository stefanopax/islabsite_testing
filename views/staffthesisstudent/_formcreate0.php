<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Request */
/* @var $form yii\widgets\ActiveForm */
/* @var $thesis app\models\Thesis */
?>

<div class="request-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=$form->field($model, 'thesis')->textInput(['readonly' => true, 'value' => $thesis ]) ?>

    <?= $form->field($model, 'student')->widget(\kartik\select2\Select2::className(),[
        'data' => ArrayHelper::map(User::find()->leftjoin('auth_assignment', 'id::integer=user_id::integer')->where(['item_name' => 'student'])->all(), 'id', 'username'),
        'language' => 'it',
        'options' => ['placeholder' => 'Select a student ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'confirmed_at')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
