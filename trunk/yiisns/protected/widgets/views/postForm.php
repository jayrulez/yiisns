<div id="post-form">
	<?php echo CHtml::beginForm(array('/post/create')); ?>
		<fieldset>
			<?php if(count($aspectIds)): ?>
			<?php foreach($aspectIds as $aspectId): ?>
			<?php echo CHtml::hiddenField('aspectsIds[]', $aspectId, array(
				'id'=>'target-aspect-'.$aspectId,
			)); ?>
			<?php endforeach; ?>
			<?php endif; ?>
		</fieldset>
		<fieldset class="content-field">
			<?php echo CHtml::activeTextArea($post, 'content', array(
				'cols'=>1,
				'rows'=>1,
			)); ?>
		</fieldset>
		<fieldset class="submit-field-and-options clearfix">
			<div class="options">
			</div>
			<div class="submit-field">
				<?php echo CHtml::htmlButton(Yii::t('application','Share'), array(
					'type'=>'submit',
				)); ?>
			</div>
		</fieldset>
	<?php echo CHtml::endForm(); ?>
</div>