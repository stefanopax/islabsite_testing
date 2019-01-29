<title>Islab | Create subscriber</title>
<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Subscribes */
/* @var $exam app\models\Exam */

$this->title = 'Create Subscribes';
$this->params['breadcrumbs'][] = ['label' => 'Subscribes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="subscribes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formcreate', [
        'model' => $model,
        'exam' => $exam,
    ]) ?>

</div>
