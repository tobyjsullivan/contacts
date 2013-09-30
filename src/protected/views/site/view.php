<?php
/* @var $this SiteController */
/* @var $contact Contact */
/* @var $followerCount Int|NULL */

$this->pageTitle=$contact->name;
?>

<?php 
if(!empty($contact->phone)) {
?>
<p><strong>Phone:</strong> <?php echo $contact->phone; ?></p>
<?php 
}

if(!empty($contact->twitter)) {
?>
<p>
<?php echo CHtml::link('@'.$contact->twitter, 'https://twitter.com/'.$contact->twitter, array('target' => '_blank'))?> 
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
?>
<p class="text-right"><?php echo CHtml::link('Edit Contact', array('/site/edit', 'contact_id' => $contact->contact_id), array('class' => 'btn btn-lg btn-default')); ?></p>