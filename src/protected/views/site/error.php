<?php
/* @var $this SiteController */
/* @var $error array */

$this->showNav = false;

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<?php error_log(print_r(get_defined_vars(), true)); ?>

<h2>Error <?php echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>
