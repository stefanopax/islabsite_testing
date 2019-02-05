<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\CourseSite;

/* @var $this yii\web\View */
/* @var $model app\models\File */
/* @var $form yii\widgets\ActiveForm */

$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->id);

?>

<div class="file-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_public')->checkbox() ?>

	<?php if(isset($role['admin'])){ ?>
		<?= $form->field($model, 'course_site')->widget(\kartik\select2\Select2::className(),[
        'data' => ArrayHelper::map(CourseSite::find()->where(['is_current' => true])->all(), 'id', 'title'),
        'language' => 'it',
        'options' => ['placeholder' => 'Select a course_site ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?>
	<?php } else {  ?>
		<?= $form->field($model, 'course_site')->widget(\kartik\select2\Select2::className(),[
        'data' => ArrayHelper::map(CourseSite::find()->leftjoin('handles', '"handles"."course" = "course_site"."course"')->where(['is_current' => true])->andWhere(['=','"handles"."staff"',Yii::$app->user->identity->getId()])->all(), 'id', 'title'),
        'language' => 'it',
        'options' => ['placeholder' => 'Select a course_site ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
	} ?>
	
    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
