<?php
/* @var $this BulletinController */
/* @var $model Bulletin */


$this->params['breadcrumbs'] = array(
    'Добавить объявление',
);
?>

<h1>Добавить объявление</h1>

<script type="">
    console.log('dfdfd');
    $('#castedsdddddr').autocomplete();
    console.log('dfdfd4');
</script>

<?php echo $this->render('_form', array('model' => $model)); ?>
