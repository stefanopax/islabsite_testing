<title>Islab | Teacher</title>
<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $model app\models\Exam */

$this->title = ('Esami');
$this->params['breadcrumbs'][] = $this->title;
$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>

<h1><?= Html::encode($this->title) ?></h1>

<p> Welcome <?= Yii::$app->user->identity->getName() ?> <?= Yii::$app->user->identity->getSurname() ?>  </p>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->errorSummary($model); ?>

<?= $form->field($model, 'title')->fileInput() ?>

<button>Submit</button>

<?php ActiveForm::end() ?>