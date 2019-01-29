<title>Islab | Teacher</title>
<?php

use yii\helpers\Html;

$this->title = ('Home');
$this->params['breadcrumbs'][] = $this->title;
$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>

 <h1><?= Html::encode($this->title) ?></h1>

 <p> Welcome <?= Yii::$app->user->identity->getName() ?> <?= Yii::$app->user->identity->getSurname() ?>  </p>



