<?php
/* @var $this AjaxController */
/* @var $followerCount Int */

if($followerCount == 5000) {
	$followerCount = "5000+";
}
?>
{
	"count": "<?php echo $followerCount; ?>"
}