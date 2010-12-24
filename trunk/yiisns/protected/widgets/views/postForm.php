<div id="post-form-content">
	<?php echo CHtml::beginForm(array('/post/create')); ?>
		<fieldset class="content-field">
			<div class="post-target-aspects">
			<?php if(count($this->aspectIds)): ?>
			<?php foreach($this->aspectIds as $aspectId): ?>
				<?php echo CHtml::hiddenField('aspects[]', $aspectId); ?>
			<?php endforeach; ?>
			<?php else: ?>
			<!--select multiple aspects from here-->
			<?php endif; ?>
			</div>
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