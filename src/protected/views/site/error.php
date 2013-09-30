<?php
/* @var $this SiteController */
/* @var $error array */

$this->showNav = false;

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<h2>Error <?php echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>

<pre>
<?php print_r($error); ?>
</pre>