<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

$this->showNav = false;
?>
<style type="text/css">
div.header-wrapper {
	background-color: #333;
}

h1.header {
	color: #fff;
}

.tagline {
	margin-top: 50px;
	margin-bottom: 50px;
	color: #fff;
	font-size: 48px;
	text-shadow: 0 0 20px #333;
}
</style>

</div>
</div>

<div class="row">
	<div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
<div class="text-center">
	<p class="tagline">Welcome to your new address book.</p>
	<p><?php 
	$image_url = Yii::app()->params['assetHost'] . "/images/sign-in-with-twitter-gray.png";
	$image_tag = CHtml::image($image_url, 'Sign in with Twitter');
	echo CHtml::link($image_tag, array('/auth/SignInWithTwitter'));
	 ?></p>
</div>

<script src="<?php echo Yii::app()->params['assetHost']; ?>/js/backstretch.js"></script>
<script>
$(".content-wrapper").backstretch("<?php echo Yii::app()->params['assetHost']; ?>/images/bg-book.jpg");
</script>
