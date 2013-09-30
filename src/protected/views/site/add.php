<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm  */

?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'htmlOptions' => array('class' => 'form'),
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
	<?php echo CHtml::errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name', array('class' => 'form-control')); ?>
		<p class="hint">
			This field is required.
		</p>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone', array('class' => 'form-control')); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->labelEx($model,'twitter'); ?>
		<div class="input-group">
	  		<span class="input-group-addon">@</span>
			<?php echo $form->textField($model,'twitter', array('class' => 'form-control')); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo CHtml::submitButton($this->pageTitle, array('class' => 'btn btn-primary btn-lg form-control input-lg')); ?>
	</div>

<?php $this->endWidget(); ?>