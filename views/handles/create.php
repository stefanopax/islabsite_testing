<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Handles */

$this->title = 'Create Handles';
$this->params['breadcrumbs'][] = ['label' => 'Handles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="handles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
