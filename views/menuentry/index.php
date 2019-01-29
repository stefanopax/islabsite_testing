<?php
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<?php

use yii\web\View;

/* @var $this yii\web\View */

$sorturl = Yii::$app->urlManager->createUrl(['menuentry/changesort']);
/*
    $script = <<<JS
    UIkit.sortable(element,options);
    JS;
*/

$script = <<<JS
$('#sortlist').sortable({
    axis: 'y',
    update: function (event, ui) {
        var data = $('#sortlist').sortable('serialize');

        $.ajax({
            type: "POST",
            url: "$sorturl",
            data: data,
            success: function(data) {
                console.log(data);
            }
        });
    }
});
JS;

?>

<div class="uk-section uk-section-xsmall uk-section-muted">

	<div class="uk-container">
		<div class="uk-card uk-card-body uk-padding-small uk-text-left uk-margin-small">
			<h3><?= $this->title?> </h3>
		</div>

        <?php
        if (!empty($model)) {
            ?>
			<ul id="sortlist" class="uk-grid-small uk-child-width-1-1" uk-sortable="handle: .uk-sortable-handle" uk-grid>
                <?php
                foreach ($model as $row) {
                    //$content_string = '';
                    $cid = $row['id'];
                    $content_string = 'Title: ' . $row['title'];
                    if ($row['is_deleted'] == 1) {
                        $content_string .= ' - <span class="uk-text-danger">menuentry eliminata</span>';
                    }
                    $content_string .= '<br>';
                    if(!is_null($row['link']))
                        $content_string .= '<b>Info (position = ' . $row['position'] . ')</b>: ' . $row['link'];
                    else
                        $content_string .= '<b>Info (position = ' . $row['position'] . ')</b>: ' . $row['content'];
                    ?>
					<li id="<?= 'item' . '_' . $cid; ?>">
						<div class="uk-card uk-card-default uk-padding-small uk-text-left uk-margin-left uk-margin-right uk-sortable-handle">
							<span class="uk-sortable-handle uk-margin-small-right" uk-icon="icon: table"></span><br><?= $content_string; ?>
						</div>
					</li>
                    <?php
                }
                ?>
			</ul>
            <?php
        } else {
            ?>
			<div class="uk-card uk-card-body uk-padding-small uk-text-left uk-margin-small">
				Non esistono contenuti da ordinare per l'elemento selezionato.
			</div>
            <?php
        }
        ?>
	</div>
</div>
<?php
$this->registerJs($script, View::POS_READY);
?>