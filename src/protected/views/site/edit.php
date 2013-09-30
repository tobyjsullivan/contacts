<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $contact_id Int  */

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
		<?php echo CHtml::submitButton("Save Changes", array('class' => 'btn btn-primary btn-lg form-control input-lg')); ?>
	</div>
	
<p class="text-right"><?php echo CHtml::link('Delete Contact', array('/site/delete', 'contact_id' => $contact_id), array('class' => 'btn btn-lg btn-danger form-control input-lg')); ?></p>

<?php $this->endWidget(); ?>