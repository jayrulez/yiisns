<div id="post-form-content">
	<?php echo CHtml::beginForm(array('/post/create')); ?>
		<fieldset class="content-field">
			<div class="post-target-aspects">
			<?php if(count($this->aspectIds)): ?>
			<?php foreach($this->aspectIds as $aspectId): ?>
				<?php echo CHtml::hiddenField('aspects[]', $aspectId); ?>
			<?php endforeach; ?>
			<?php else: ?>
				<?php echo CHtml::hiddenField('aspects', Post::ALL_ASPECTS); ?>
			<!--select multiple aspects from here-->
			<?php endif; ?>
			</div>
			<?php echo CHtml::activeTextArea($model, 'content', array(
				'rows'=>1,
				'cols'=>1,
			)); ?>
		</fieldset>
		<fieldset class="submit-field-and-options clearfix">
			<div class="options">
			</div>
			<div class="submit-field">
				<?php echo CHtml::submitButton(Yii::t('application', 'Share'), array('class'=>'submit')); ?>
			</div>
		</fieldset>
	<?php echo CHtml::endForm(); ?>
</div>