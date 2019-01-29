<title>Islab | Admin - Create student</title>
<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $stud app\models\Student */

$this->title = 'Create Student';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'stud' => $stud,
    ]) ?>

</div>

