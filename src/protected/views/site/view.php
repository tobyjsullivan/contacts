<?php
/* @var $this SiteController */
/* @var $contact Contact */
/* @var $followerCount Int|NULL */

$this->pageTitle=$contact->name;
?>

<?php 
if(!empty($contact->phone)) {
?>
<p><strong>Phone:</strong> <?php echo CHtml::encode($contact->phone); ?></p>
<?php 
}

if(!empty($contact->twitter)) {
?>
<p>
<?php echo CHtml::link('@'.CHtml::encode($contact->twitter), 'https://twitter.com/'.CHtml::encode($contact->twitter), array('target' => '_blank'))?> 
<?php 
if($followerCount != null) {
	if($followerCount == 5000) {
		$followerCount = '5000+';
	}

	echo '('.$followerCount.' Followers)';
}
?>
</p>
<?php 
}

if(empty($contact->phone) && empty($contact->twitter)) {
	?>
	<p class="text-muted">You have no contact information for this person.</p>
	<?php 
}
?>
<p class="text-right"><?php echo CHtml::link('Edit Contact', array('/site/edit', 'contact_id' => $contact->contact_id), array('class' => 'btn btn-lg btn-default')); ?></p>