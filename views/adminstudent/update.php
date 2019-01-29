<title>Islab | Admin - Edit student</title>
<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $student app\models\Student */

$this->title = 'Update Student: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'stud' => $student,
    ]) ?>

</div>
