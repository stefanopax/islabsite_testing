<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Menuentry */
/* @var $form yii\widgets\ActiveForm */
$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());

?>

<div class="menuentry-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 10]) ?>

    <?= $form->field($model, 'is_deleted')->checkbox() ?>

    <?php if(isset($role['admin'])) { ?>
        <?= $form->field($model, 'staff_id')->widget(\kartik\select2\Select2::className(),[
            'data' => ArrayHelper::map(User::find()->leftjoin('auth_assignment', 'id::integer=user_id::integer')->where(['item_name' => 'staff'])->orWhere(['=','item_name','teacher'])->all(), 'id', 'username'),
            'language' => 'it',
            'options' => ['placeholder' => 'Select a staff member ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Staff');?>
    <?php } else { ?>
        <?= $form->field($model, 'staff_id')->hiddenInput(['value'=> Yii::$app->user->identity->getId()])->label(false); ?>
    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
