<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo Yii::app()->getLocale()->getId(); ?>" dir="<?php echo Yii::app()->getLocale()->getOrientation(); ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo Yii::app()->charset; ?>" />
<meta name="language" content="<?php echo Yii::app()->getLocale()->getId(); ?>" />
<script type="text/javascript">
        var baseUrl = '<?php echo Yii::app()->getBaseUrl(true); ?>';
</script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(); ?>/css/common.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(); ?>/css/layout.css" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<!--[if lt IE 8]>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(); ?>/css/ie.css" />
<![endif]-->
</head>
<body<?php echo Layout::hasRegions('sidebar.left','sidebar.right') 
? ' class="sidebars"' : Layout::hasRegions('sidebar.left') 
? ' class="sidebar-left"' : Layout::hasRegions('sidebar.right') 
? ' class="sidebar-right"' : ''; ?>>
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
					<div id="canvas-content" class="clearfix">
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
					<div id="footer-content">
					</div>
				</div>
				<!-- /footer -->
			</div>
		</div>
	</div>
</body>
</html>