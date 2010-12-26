			<div class="aspect-block">
				<?php if($showLink): ?>
				<div class="aspect-link"><?php echo $aspect->getLink(); ?></div>
				<?php endif; ?>
				<?php if(count($aspect->contacts)): ?>
				<div class="aspect-contacts">
					<div class="aspect-contacts-row clearfix">
						<?php $counter = 1; ?>
						<?php foreach($aspect->contacts as $contact): ?>
						<?php
						if($counter == $contactsPerRow): 
							$counter = 0; 
							$appendClass  = ' last'; 
						elseif($counter == ($contactsPerRow  - 1)): 
							$appendClass = ' second-to-last'; 
						else: 
							$appendClass = ''; 
						endif; 
						?>
						<div class="aspect-contact-icon<?php echo $appendClass; ?>">
							<?php echo $contact->contact->getImageLink(User::PHOTO_SIZE_MINI); ?>
						</div>
						<?php $counter++; ?>
						<?php endforeach; ?>
					</div>
						
				</div>
				<?php else: ?>
				<?php echo Yii::t('application', 'No contacts'); ?>
				<?php endif; ?>
			</div>