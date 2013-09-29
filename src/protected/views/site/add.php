<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm  */

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
			This field is required.
		</p>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone', array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->labelEx($model,'twitter'); ?>
		<div class="input-group">
	  		<span class="input-group-addon">@</span>
			<?php echo $form->textField($model,'twitter', array('class' => 'form-control')); ?>
		</div>
		<?php echo $form->error($model,'twitter'); ?>
	</div>

	<div class="form-group">
		<?php echo CHtml::submitButton($this->pageTitle, array('class' => 'btn btn-primary btn-lg form-control input-lg')); ?>
	</div>

<?php $this->endWidget(); ?>
	</div>
</div>