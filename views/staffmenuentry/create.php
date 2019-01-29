<title>Islab | Staff - Create menuentry</title>
<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Menuentry */

$this->title = 'Create Menuentry';
$this->params['breadcrumbs'][] = ['label' => 'Menuentries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="menuentry-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
