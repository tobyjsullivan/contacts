<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
    	<script src="<?php echo Yii::app()->params['assetHost']; ?>/js/jquery-1.10.2.min.js"></script>
    	<script src="<?php echo Yii::app()->params['assetHost']; ?>/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['assetHost']; ?>/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['assetHost']; ?>/css/contacts.css" />
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	</head>
	<body>
		<?php
		if($this->showNav) {
		?>
		<div class="nav-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4">
						<ul class="nav nav-pills nav-justified hidden-xs">
							<li>
							<?php echo CHtml::link('<span class="glyphicon glyphicon-book"></span> Contact List', array('/site/dashboard')); ?>
							</li>
							<li>
							<?php echo CHtml::link('Sign Out <span class="glyphicon glyphicon-log-out"></span>', array('/auth/signout')); ?>
							</li>
						</ul>
						<ul class="nav nav-tabs nav-justified visible-xs">
							<li>
							<?php echo CHtml::link('<span class="glyphicon glyphicon-log-out"></span> Sign Out', array('/auth/signout')); ?>
							</li>
							<li>
							<?php echo CHtml::link('<span class="glyphicon glyphicon-book"></span> Contact List', array('/site/dashboard')); ?>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<?php 
		}
		?>
		<div class="header-wrapper">
			<div class="container">
				<h1 class="header text-center"><?php echo CHtml::encode($this->pageTitle); ?></h1>
			</div>
		</div>
		<div class="container content">
			<div class="row">
				<div class="col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4">
				
					<?php echo $content; ?>
					
				</div>
			</div>
		</div>
		<div class="container">
			<footer class="footer text-center">
				<p>Built by <a href="https://tobysullivan.net">Toby Sullivan</a> for HootSuite.</p>
			</footer>
		</div>
	</body>
</html>