<title>Islab | Admin - Create staff</title>
<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $staff app\models\Staff */

$this->title = 'Create Staff';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'staff' => $staff,
    ]) ?>

</div>
