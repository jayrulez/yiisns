<div class="action" id="contact-requests">
	<div class="action-content">
		<div id="requests">
		<?php if(count($requests)): ?>
		<?php foreach($requests as $request): ?>
			<div class="request">
				<?php echo $request->user->getLink(); ?>
				<?php echo CHtml::link(Yii::t('application','delete'), array('/contact/deleteRequest','user_id'=>$request->user_id, 'contact_id'=>$request->contact_id)); ?>
				<?php echo CHtml::link(Yii::t('application','confirm'), array('/contact/confirmRequest','user_id'=>$request->user_id, 'contact_id'=>$request->contact_id)); ?>
			</div>
		<?php endforeach; ?>
		<?php else: ?>
			<div id="no-requests"></div>
		<?php endif; ?>
		</div>
	</div>
</div>