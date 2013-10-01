<?php
/* @var $this SiteController */
/* @var $contacts array[Contact] */

$this->pageTitle="Contact List";
?>
<div class="text-center">
	<p class="text-center"><?php echo CHtml::link('New Contact', array('/site/add'), array('class' => 'btn btn-lg btn-primary')); ?></p>
	<?php
	foreach($contacts as $curContact) {
		?>
	<div class="contact">
		<p><?php echo CHtml::link(CHtml::encode($curContact->name), array('/site/view','contact_id'=>$curContact->contact_id)); ?></p>
	</div>
		<?php
	}
	?>
	
</div>