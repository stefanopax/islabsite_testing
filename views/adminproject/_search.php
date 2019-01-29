<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this yii\web\View */
/* @var $model app\models\SearchProject */
/* @var $form yii\widgets\ActiveForm */
?>
<head>
    <div class="site-index">
        <?php
            NavBar::begin(['brandLabel' => Html::img('/img/islab_mini.png') ]);
            echo Nav::widget([
                    'options' => ['class' => 'uk-navbar-item'],
                    'items' => [
                        ['label' => 'Student', 'url' => ['/adminstudent']],
                        ['label' => 'Teacher', 'url' => ['/adminteacher']],
                        ['label' => 'Staff', 'url' => ['/adminstaff']],
                        ['label' => 'Project', 'url' => ['/adminproject']],
                        ['label' => 'Thesis', 'url' => ['/landing/thesis']],
                    ],
            ]);
            NavBar::end();

    ?>
    </div>
</head>
<div class="project-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'link') ?>

    <?= $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'image') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
