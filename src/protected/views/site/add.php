<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm  */

$this->pageTitle="New Contact";
?>

<div class="row">
	<div class="col-sm-12 col-md-offset-3 col-md-6">
		<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'add-form',
	'htmlOptions' => array('class' => 'form'),
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name', array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'name'); ?>
		<p class="hint">
			Hint: This field is required.
		</p>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->passwordField($model,'phone', array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->labelEx($model,'twitter'); ?>
		<?php echo $form->passwordField($model,'twitter', array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'twitter'); ?>
	</div>

	<div class="form-group">
		<?php echo CHtml::submitButton('Add Contact', array('class' => 'btn btn-primary form-control')); ?>
	</div>

<?php $this->endWidget(); ?>
	</div>
</div>