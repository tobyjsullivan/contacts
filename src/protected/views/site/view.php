<?php
/* @var $this SiteController */
/* @var $contact Contact */
/* @var $followerCount Int|NULL */

$this->pageTitle=$contact->name;
?>

<?php 
if(!empty($contact->phone)) {
?>
<p><strong><?php echo $contact->phone; ?></strong></p>
<?php 
}

if(!empty($contact->twitter)) {
?>
<p>
<?php echo CHtml::link('@'.$contact->twitter, 'https://twitter.com/'.$contact->twitter)?> 
<?php 
if($followerCount != null) {
	echo '('.$followerCount.' Followers)';
}
?>
</p>
<?php 
}
?>
<p class="text-right"><?php echo CHtml::link('Edit Contact', array('/site/edit'), array('class' => 'btn btn-lg btn-default')); ?></p>