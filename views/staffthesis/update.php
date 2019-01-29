<title>Islab | Staff - Edit thesis</title>
<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Thesis */

$this->title = 'Update Thesis: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Theses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="thesis-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
