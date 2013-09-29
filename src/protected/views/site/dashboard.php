<?php
/* @var $this SiteController */

$this->pageTitle="Contact List";
?>
<div class="text-center">
	<p class="text-center"><?php echo CHtml::link('New Contact', array('/site/add'), array('class' => 'btn btn-lg btn-default')); ?></p>
	<div class="contact">
		<p><?php echo CHtml::link('Geoff Sanders', array('/site/view')); ?></p>
	</div>
	<div class="contact">
		<p>Josefina Lopez</p>
	</div>
	<div class="contact">
		<p>Letha Cook</p>
	</div>
	<div class="contact">
		<p>Max Edwards</p>
	</div>
	
</div>