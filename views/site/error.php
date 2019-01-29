<title>Islab | Error</title>
<?php

/* @var $exception Exception */
/* @var $message string */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?php
        if (strpos($this->title, '403')){
            echo 'Azione non consentita';
            $custom_message = 'Non ti è permesso accedere a questa pagina.';
        }
        elseif (strpos($this->title, '404')){
            echo 'Pagina non trovata';
            $custom_message = 'La pagina alla quale  stai tentando di accedere non esiste.';
        }
        else {
            echo $this->title;
            $custom_message = $exception->getMessage();
        }
        ?>
    </h1>
    <div class="alert alert-danger">
        <?= $custom_message ?>
    </div>
    <?php
        echo Html::a('Torna indietro', ['/site/index']);
    ?>

</div>
