<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $staff app\models\Staff */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($staff, 'cellphone')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($staff, 'phone')->textInput(['maxlength' => true]) ?>
	 
	<?= $form->field($staff, 'mail')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($staff, 'room')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($staff, 'address')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($staff, 'image')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($staff, 'fax')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($staff, 'role')->textInput(['maxlength' => true]) ?>
	 
	<?= $form->field($staff, 'description')->textarea(['rows' => 6]) ?>  
	
	<?= $form->field($staff, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_disabled')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
