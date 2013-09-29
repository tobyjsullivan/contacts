<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<div class="row">
	<div class="col-sm-12 text-center">
		<p><?php echo CHtml::link('Sign in with Twitter', array('/site/dashboard'), array('class' => 'btn btn-primary')); ?></p>
	</div>
</div>