<div class="action" id="contact-requests">
	<div class="action-content">
		<?php if($type===Request::TYPE_RECEIVED): ?>
			<div class="received-requests">
			<?php foreach($requests as $request): ?>
				<div class="request">
					<?php echo $request->user->getLink(); ?>
					<?php echo CHtml::link(Yii::t('application','delete'), array('/contact/deleteRequest','user_id'=>$request->user_id, 'contact_id'=>$request->contact_id)); ?>
					<?php echo CHtml::link(Yii::t('application','confirm'), array('/contact/confirm','user_id'=>$request->user_id, 'contact_id'=>$request->contact_id)); ?>
				</div>
			<?php endforeach; ?>
			</div>
		<?php else: ?>
			<div id="sent-requests">
			<?php foreach($requests as $request): ?>
				<div class="sent-request">
					<?php echo $request->contact->getLink(); ?>
					<?php echo CHtml::link(Yii::t('application','delete'), array('/contact/deleteRequest','user_id'=>$request->user_id, 'contact_id'=>$request->contact_id)); ?>
				</div>
			<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</div>