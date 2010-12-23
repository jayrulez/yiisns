<div id="header-content" class="clearfix">
	<div id="home-link">
		<?php echo CHtml::link('', Yii::app()->homeUrl); ?>
	</div>
	<div id="main-nav" class="clearfix">
		<div id="global-search">
			<?php echo CHtml::beginForm(array('/search/index'), 'get'); ?>
				<fieldset class="search-button">
					<?php echo CHtml::submitButton(Yii::t('application', 'Search'), array('class'=>'search-submit')); ?>
				</fieldset>
				<fieldset class="search-field">
					<?php echo CHtml::textField('q', '', array('class'=>'search-text')); ?>
				</fieldset>
			<?php echo CHtml::endForm(); ?>
		</div>
		<?php if(($user = Yii::app()->user->getModel()) !== null): ?>
		<div id="user-nav">
			<ul>
				<li><?php echo $user->getLink(); ?></li>
				<li><?php echo CHtml::link(Yii::t('application', 'logout'), Yii::app()->user->logoutUrl); ?></li>
			</ul>
		</div>
		<?php else: ?>
		<div id="guest-nav">
			<ul>
				<li><?php echo CHtml::link(Yii::t('application', 'login'), Yii::app()->user->loginUrl); ?></li>
				<li><?php echo CHtml::link(Yii::t('application', 'register'), Yii::app()->user->registerUrl); ?></li>
			</ul>
		</div>
		<?php endif; ?>
	</div>
</div>