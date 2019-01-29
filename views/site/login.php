<title>Islab | Login</title>
<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = ('Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>


    <?php $form = ActiveForm::begin(); ?>

        <?=  $form->field($model, 'username')->textInput(['autofocus' => true, 'style'=>'width:400px']);?>

        <?=  $form->field($model, 'password')->passwordInput(['style'=>'width:400px']);?>

         <?= $form->field($model, 'rememberMe')->checkbox()?>

       <?=  Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button', 'value' => 'login'])?>

    <?php ActiveForm::end(); ?>

</div>