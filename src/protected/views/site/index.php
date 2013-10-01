<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

$this->showNav = false;
?>

<div class="text-center">
	<p>Welcome to your new contact list. It's super handy!</p>
	<p><?php 
	$image_url = Yii::app()->params['assetHost'] . "/images/sign-in-with-twitter-gray.png";
	$image_tag = CHtml::image($image_url, 'Sign in with Twitter');
	echo CHtml::link($image_tag, array('/auth/SignInWithTwitter'));
	 ?></p>
</div>