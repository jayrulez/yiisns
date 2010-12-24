<div id="post-form-content">
	<?php echo CHtml::beginForm(array('/post/create')); ?>
		<fieldset class="content-field">
			<?php if($this->aspectId !== null): ?>
			<?php echo CHtml::hiddenField('aspect_id', $this->aspectId); ?>
			<?php endif; ?>
			<?php echo CHtml::activeTextArea($model, 'content', array(
				'rows'=>3,
				'cols'=>60,
			)); ?>
		</fieldset>
		<fieldset class="submit-field">
			<?php echo CHtml::submitButton(Yii::t('application', 'Post')); ?>
		</fieldset>
	<?php echo CHtml::endForm(); ?>
</div>