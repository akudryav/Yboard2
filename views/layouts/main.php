<?php

$this->beginContent('@app/views/layouts/index.php');

?>

<div class="container-wrapper">
    <div class="row content_page__row">
    <?= $content ?>
    </div>
</div>


<?php $this->endContent(); ?>