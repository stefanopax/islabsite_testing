<title>Islab | Edit course site</title>
<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CourseSite */

$this->title = 'Update Course Site: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Course Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="course-site-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
