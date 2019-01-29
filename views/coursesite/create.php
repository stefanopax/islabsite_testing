<title>Islab | Create course site</title>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Course;

/* @var $this yii\web\View */
/* @var $model app\models\CourseSite */

$this->title = 'Create Course Site';
$this->params['breadcrumbs'][] = ['label' => 'Course Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="course-site-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?php if(isset($role['admin'])) { ?>

    <?= $form->field($model, 'course')->widget(\kartik\select2\Select2::className(),[
        'data' => (ArrayHelper::map(Course::find()->all(), 'id', 'title')),
        'language' => 'it',
        'options' => ['placeholder' => 'Select a Course ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?>

    <?php } else { ?>

        <?= $form->field($model, 'course')->widget(\kartik\select2\Select2::className(),[
        'data' => (ArrayHelper::map(Course::find()->leftjoin('handles', 'id::integer=course::integer')
            ->where(['handles.staff' => Yii::$app->user->identity->getId()])->all(), 'id', 'title')),
        'language' => 'it',
        'options' => ['placeholder' => 'Select a Course ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); }
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
