<div class="stream-comment-form-content">
	<?php echo CHtml::beginForm(array('/comment/create')); ?>
		<fieldset class="stream-field">
			<?php echo CHtml::activeHiddenField($model, 'post_id', array(
				'value'=>$postId,
				'id'=>'comment-for-post-'.$postId,
			)); ?>
		</fieldset>
		<fieldset class="content-field">
			<?php echo CHtml::activeTextArea($model, 'content', array(
				'rows'=>1,
				'cols'=>1,
				'id'=>'comment-on-post-'.$postId,
			)); ?>
		</fieldset>
		<fieldset class="submit-field clearfix">
			<?php echo CHtml::submitButton(Yii::t('application', 'Comment'), array('class'=>'submit')); ?>
		</fieldset>
	<?php echo CHtml::endForm(); ?>
</div>