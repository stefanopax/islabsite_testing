<title>Islab | Edit subscriber</title>
<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Subscribes */

$this->title = 'Update Subscribes: ' . $model->exam;
$this->params['breadcrumbs'][] = ['label' => 'Subscribes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->exam, 'url' => ['view', 'exam' => $model->exam, 'student' => $model->student, 'date' => $model->date]];
$this->params['breadcrumbs'][] = 'Update';
$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="subscribes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
