<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/rightSidebar.css'); ?>
<div id="home-index-sidebar-right" class="sidebar-content-inner">
	<div id="userIdentity-block">
	<?php $this->widget('UserIdentityWidget'); ?>
	</div>
	<div class="break"></div>
	<div id="aspects-block">
		<div id="aspects-block-header" class="clearfix">
			<div class="title"><?php echo Yii::t('application', 'Aspects'); ?></div>
			<div class="manage"><?php echo CHtml::link(Yii::t('application', 'manage aspects'), array('/aspect/manage')); ?></div>
		</div>
		<?php if(count($user->aspects)): ?>
		<div id="aspects-block-content">
			<?php foreach($user->aspects as $aspect): ?>
			<?php if(count($aspect->contacts)): ?>
			<div class="aspect">
				<div class="aspect-link"><?php echo $aspect->getLink(); ?></div>
				<div class="aspect-contacts">
					<div class="aspect-contact-row clearfix">
					<?php $n = 1; $contactsPerRow = 9; ?>
					<?php foreach($user->contacts as $contact): ?>
						<?php if($n == $contactsPerRow): $n = 0; $c  = ' last'; elseif($n == ($contactsPerRow  - 1)): $c = ' second-to-last'; else: $c = ''; endif; ?>
						<div class="aspect-contact-icon<?php echo $c; ?>">
							<?php echo $contact->contact->getImageLink(User::PHOTO_SIZE_MINI); ?>
						</div>
					<?php $n++; ?>
					<?php endforeach; ?>
					</div>
				</div>
			</div>
			<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<?php else: ?>
			<div class="no-aspects"><?php echo Yii::t('application', 'No aspects'); ?></div>
		<?php endif; ?>
	</div>
</div>