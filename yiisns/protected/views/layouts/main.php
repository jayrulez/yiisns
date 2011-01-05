<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo Yii::app()->getLocale()->getId(); ?>" dir="<?php echo Yii::app()->getLocale()->getOrientation(); ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo Yii::app()->charset; ?>" />
<meta name="language" content="<?php echo Yii::app()->getLocale()->getId(); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(); ?>/css/common.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(); ?>/css/layout.css" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<!--[if lt IE 8]>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(); ?>/css/ie.css" />
<![endif]-->
</head>
<body>
	<div id="page-container">
		<div id="page">
			<div id="header-container">
				<!-- header -->
				<div id="header">
				<?php $this->widget('HeaderWidget'); ?>
				</div>
				<!-- /header -->
			</div>
			
			<div id="canvas-container">
				<!-- canvas -->
				<div id="canvas">
					<?php
					if(Layout::hasRegions('sidebar.left','sidebar.right'))
					{
						$tagClass = ' class="sidebars clearfix"';
					}else if(Layout::hasRegions('sidebar.left'))
					{
						$tagClass = ' class="sidebar-left clearfix"';
					}else if(Layout::hasRegions('sidebar.right'))
					{
						$tagClass = ' class="sidebar-right clearfix"';
					}else{
						$tagClass = '';
					}
					?>
					<div id="canvas-content"<?php echo $tagClass; ?>>
					
						<?php if(Layout::hasRegion('sidebar.left')): ?>
						<!-- sidebar-left -->
						<div id="sidebar-left" class="sidebar">
							<div class="sidebar-content">
								<?php Layout::renderRegion('sidebar.left'); ?>
							</div>
						</div>
						<!-- /sidebar-left -->
						<?php endif; ?>
								
						<div id="content-container">
							<!-- content -->
							<div id="content">
								<?php echo $content; ?>
							</div>
							<!-- /content -->
						</div>
							
						<?php if(Layout::hasRegion('sidebar.right')): ?>
						<!-- sidebar-right -->
						<div id="sidebar-right" class="sidebar">
							<div class="sidebar-content">
								<?php Layout::renderRegion('sidebar.right'); ?>
							</div>
						</div>
						<!-- /sidebar-right -->
						<?php endif; ?>
						
					</div>
				</div>
				<!-- /canvas -->
			</div>
			
			<div id="footer-container">
				<!-- footer -->
				<div id="footer">
					<?php $this->widget('FooterWidget'); ?>
				</div>
				<!-- /footer -->
			</div>
		</div>
	</div>
</body>
</html>