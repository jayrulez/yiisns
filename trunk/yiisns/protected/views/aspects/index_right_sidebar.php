<div id="aspect-sidebar-right" class="sidebar-content-inner">
	<div class="sidebar-item" id="user-identity-block">
		<div class="sidebar-item-content">
			<?php $this->widget('UserIdentityWidget', array(
				'user'=>$user,
				'viewerId'=>Yii::app()->user->getId(),
			)); ?>
		</div>
	</div>
	
	<div class="separator"></div>
	
	<div class="sidebar-item" id="aspects-block">
	
		<div class="sidebar-item-header clearfix">
			<div class="title"><?php echo Yii::t('application', 'My Contacts'); ?></div>
			<div class="link"><?php echo CHtml::link(Yii::t('application', 'manage contacts'), array('/contacts/manage')); ?></div>
		</div>
		
		<div class="sidebar-item-content">
		<?php if(count($user->aspects)): ?>
		
			<?php foreach($user->aspects as $aspect): ?>
				<?php $this->renderPartial('/partials/aspect_block', array(
					'aspect'=>$aspect,
					'contactsPerRow'=>9,
					'showLink'=>true,
				)); ?>
			<?php endforeach; ?>
			
		<?php else: ?>
			<div class="no-aspects"><?php echo Yii::t('application', 'No aspects'); ?></div>
		<?php endif; ?>
		</div>
	</div>
</div>
<?php
$juiCss = Yii::app()->baseUrl.'/css/start';
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerCssFile($juiCss.'/jquery.ui.all.css');
Yii::app()->clientScript->registerScript('toggle-aspect-contacts','
	$(".aspect-contacts .empty").each(function(index) {
		$(this).parents(".aspect-contacts").hide();
	});
	$(".aspect-contacts").each(function(index) {
		$(this).parents(".aspect-block").find(".aspect-link a.toggle-aspect-contacts").addClass("ui-icon");
		if($(this).is(":visible"))
		{
			$(this).parents(".aspect-block").find(".aspect-link a.toggle-aspect-contacts").addClass("ui-icon-carat-1-n");
		}else{
			$(this).parents(".aspect-block").find(".aspect-link a.toggle-aspect-contacts").addClass("ui-icon-carat-1-s");
		}
	});
	$("a.toggle-aspect-contacts").each(function(index) {
		$(this).click(function(e) {
			if($(this).parents(".aspect-block").children(".aspect-contacts").is(":visible"))
			{
				$(this).parents(".aspect-block").children(".aspect-contacts").hide("slow");
				$(this).removeClass("ui-icon-carat-1-n").addClass("ui-icon-carat-1-s");
			}else{
				$(this).parents(".aspect-block").children(".aspect-contacts").show("slow");
				$(this).removeClass("ui-icon-carat-1-s").addClass("ui-icon-carat-1-n");
			}
		});
	});
');
?>