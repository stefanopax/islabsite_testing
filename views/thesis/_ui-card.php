<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<a class="uk-card uk-card-small uk-card-default uk-grid-collapse uk-margin uk-card-hover uk-link-reset" href="<?=  Url::toRoute(['/site/request','thesis' => $model->id]) ?>"  uk-grid>

    <div>
        <div class="uk-card-body">
            <h5 class="uk-card-title" style="color:orange;"> Title : <?= Html::encode ( $model->title ) ?></h5>
            <p> Description :  <?= Html::encode ( $model->description ) ?></p>
            <p> Course : <?= Html::encode ( $model->course ) ?></p>
            <p> Person : <?= Html::encode ( $model->ref_person ) ?></p>
            <?php if($model->trien){?>
                <p> Type :  <?=Html::encode ('triennale')?></p>
            <?php }else {?>
                <p> Type : <?=Html::encode ('magistrale')?></p>
            <?php } ?>
        </div>
    </div>
</a>
