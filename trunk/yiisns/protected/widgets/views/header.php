<?php
$user = Yii::app()->getUser()->getModel();
?>
<div id="header-content" class="clearfix">
	<div id="home-link">
		<?php echo CHtml::link(Yii::t('application','&nbsp;'), Yii::app()->homeUrl); ?>
	</div>
	<div id="global-nav" class="clearfix">
		<div id="main-menu" class="clearfix">
			<!--
			<ul>
				<li><?php echo CHtml::link(Yii::t('application','Home'), Yii::app()->homeUrl); ?></li>
			</ul>
			-->
			<?php if($user !== null): ?>
			<div id="global-search">
				<?php echo CHtml::beginForm(array('/search/index'), 'get'); ?>
					<fieldset class="search-field">
						<?php echo CHtml::textField('q', '', array('class'=>'search-text')); ?>
					</fieldset>
					<fieldset class="search-button">
						<button type="submit" class="search-submit">&nbsp;</button>
					</fieldset>
				<?php echo CHtml::endForm(); ?>
			</div>
			<?php endif; ?>
		</div>
		<div id="user-menu">
			<ul class="clearfix">
			<?php if($user !== null): ?>
				<li><?php echo $user->getLink(); ?></li>
				<li><?php echo CHtml::link(Yii::t('application', 'settings'), '#'); ?></li>
				<li><?php echo CHtml::link(Yii::t('application', 'logout'), Yii::app()->getUser()->logoutUrl); ?></li>
			<?php else: ?>
				<li><?php echo CHtml::link(Yii::t('application', 'login'), Yii::app()->getUser()->loginUrl); ?></li>
				<li><?php echo CHtml::link(Yii::t('application', 'register'), Yii::app()->getUser()->registerUrl); ?></li>
			<?php endif; ?>
			</ul>
		</div>
	</div>
</div>