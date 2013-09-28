<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/contacts.css" />
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	</head>
	<body>
		<div class="header-wrapper">
			<div class="container">
				<h1 class="header text-center"><?php echo CHtml::encode($this->pageTitle); ?></h1>
			</div>
		</div>
		<div class="container content">
			<?php echo $content; ?>
			
		</div>
		<div class="container">
			<footer class="footer text-center">
				<p>Built by <a href="https://tobysullivan.net">Toby Sullivan</a> for HootSuite.</p>
			</footer>
		</div>
	</body>
</html>