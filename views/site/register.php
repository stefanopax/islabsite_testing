<title>Islab | Register</title>
<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to register:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

	<?= $form->field($model, 'username')->hiddenInput(['value'=> $username])->label(false); ?>
    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'surname')->textInput(['autofocus' => true]) ?>
	<?= $form->field($model, 'register_id')->textInput(['autofocus' => true])->label('Matricola') ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'submit']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="col-lg-offset-1" style="color:#999;">
    </div>
</div>
<br></br><br></br><br></br>