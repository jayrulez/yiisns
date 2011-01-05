	<?php
	$counter = 0;
	foreach($contacts as $contact):
	if(++$counter === $contactsPerRow):
		$counter = 0;
		$appendClass = ' last';
	else:
		$appendClass = '';
	endif;
	?>
	<div class="aspect-contact-icon<?php echo $appendClass; ?>">
		<?php echo $contact->contact->getImageLink(); ?>
	</div>
	<?php endforeach; ?>