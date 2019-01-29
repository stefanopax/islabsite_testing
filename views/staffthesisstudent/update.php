<title>Islab | Staff - Edit requested thesis</title>
<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Request */
/* @var $stud app\models\Student */
/* @var $thesis app\models\Thesis */

$this->title = 'Update Request: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'thesis' => $model->thesis, 'student' => $model->student]];
$this->params['breadcrumbs'][] = 'Update';
$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="request-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'stud' => $stud,
        'thesis' => $thesis,

    ]) ?>

</div>
