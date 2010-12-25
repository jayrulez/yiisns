<div class="action" id="contact-sentRequests">
	<div class="action-content">
		<div id="sent-requests">
		<?php if(count($sentRequests)): ?>
		<?php foreach($sentRequests as $sentRequest): ?>
			<div class="sent-request">
				<?php echo $sentRequest->contact->getLink(); ?>
				<?php echo CHtml::link(Yii::t('application','delete'), array('/contact/deleteRequest','user_id'=>$sentRequest->user_id, 'contact_id'=>$sentRequest->contact_id)); ?>
			</div>
		<?php endforeach; ?>
		<?php else: ?>
			<div id="no-sent-requests"></div>
		<?php endif; ?>
		</div>
	</div>
</div>