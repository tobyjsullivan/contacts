<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

$this->showNav = false;
?>

<div class="text-center">
	<p><?php echo CHtml::link('Sign in with Twitter', array('/site/dashboard'), array('class' => 'btn btn-primary')); ?></p>
</div>