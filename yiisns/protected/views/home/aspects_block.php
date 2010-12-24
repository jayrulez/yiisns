<div id="aspects-block">
	<div id="aspects-block-title"><?php echo Yii::t('application', 'Aspects'); ?></div>
	<?php if(count($user->aspects)): ?>
		<div id="aspects">
			<?php foreach($user->aspects as $aspect): ?>
			<div class="aspect">
				<div class="aspect-name"><?php echo $aspect->getLink(); ?></div>
				<div class="aspect-contacts">
					<?php if(count($aspect->contacts)): ?>
						<?php foreach($user->contacts as $contact): ?>
							<?php echo $contact->contact->getLink(); ?>
						<?php endforeach; ?>
					<?php else: ?>
						<div class="no-contacts"><?php echo Yii::t('application', 'No contacts'); ?></div>
					<?php endif; ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	<?php else: ?>
		<div class="no-aspects"><?php echo Yii::t('application', 'No aspects'); ?></div>
	<?php endif; ?>
</div>