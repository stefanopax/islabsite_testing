<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<a class="uk-card uk-card-small uk-card-default uk-grid-collapse uk-margin uk-card-hover uk-link-reset" href="<?= Url::to(['staff/view', 'id' => $model->id]); ?>" uk-grid>
    <div class="uk-pull-2-5 uk-margin-remove-adjacent">
        <img src="<?= Yii::getAlias('@web').$model->image ?>" height="80" width="80">
    </div>

    <div>
        <div class="uk-card-body">
			<h5 class="uk-card-title" style="color:orange;"><?= Html::encode ( $user->name ) ?> <?= Html::encode ( $user->surname ) ?></h5>
            <h6 class="uk-card-title" style="color:black;"><?= Html::encode ( $model->role ) ?></h6>
            <p> Phone: <?= Html::encode ( $model->phone ) ?> Fax: <?= Html::encode ( $model->fax ) ?> Mail: <?= Html::encode ( $model-> mail ) ?></p>
        </div>
    </div>
</a>