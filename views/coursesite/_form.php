<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Course;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\CourseSite */
/* @var $form yii\widgets\ActiveForm */
$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
?>

<div class="course-site-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'edition')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'opening_date')->widget(\yii\jui\DatePicker::className(), []);?>

    <?= $form->field($model, 'closing_date')->widget(\yii\jui\DatePicker::className(), []);?>

    <?= $form->field($model, 'css')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_current')->checkbox() ?>

    <?php if (isset($role['admin'])) { ?>

    <?= $form->field($model, 'course')->widget(\kartik\select2\Select2::className(),[
        'data' => (ArrayHelper::map(Course::find()->all(), 'id', 'title')),
        'language' => 'it',
        'options' => ['placeholder' => 'Select a Course ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?php } else { ?>

        <?= $form->field($model, 'course')->widget(\kartik\select2\Select2::className(), [
            'data' => (ArrayHelper::map(Course::find()->leftjoin('handles', 'id::integer=course::integer')
                ->where(['handles.staff' => Yii::$app->user->identity->getId()])->all(), 'id', 'title')),
            'language' => 'it',
            'options' => ['placeholder' => 'Select a Course ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
