<title>Islab | Staff</title>
<?php

use app\models\User;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchStaff */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="staff-index">
  <?= ListView::widget([
      'dataProvider' => $dataProvider,
      'itemView' => function ($model) { 
						return $this->render('_ui-card', [
							'model' => $model,
							'user' => User::findIdentity($model->getId()),
						]);
					},
      'layout' => '{items}{pager}',
      'viewParams' => [
         'fullView' => true,
         'context' => 'main-page',
      ],
  ]);
  ?>
  </div>
