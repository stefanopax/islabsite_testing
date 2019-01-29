<?php
use yii\helpers\Html;
?>
<a class="uk-card uk-card-small uk-card-default uk-grid-collapse uk-margin uk-card-hover uk-link-reset" href="<?= Html::encode ( $model->link ) ?>" target="_blank" uk-grid>
    <div class="uk-pull-2-5 uk-margin-remove-adjacent">
        <img src="<?= Yii::getAlias('@web').$model->image ?>" height="80" width="80">
    </div>

    <div>
        <div class="uk-card-body">
            <h5 class="uk-card-title" style="color:orange;"><?= Html::encode ( $model->title ) ?></h5>
            <p><?= Html::encode ( $model->description ) ?></p>
        </div>
    </div>
</a>
