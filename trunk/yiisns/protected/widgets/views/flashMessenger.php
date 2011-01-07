							<!-- flash-messenger -->
							<?php if(count($categories)): ?>
							
								<?php foreach($categories as $category): ?>
								<?php if(Yii::app()->getUser()->hasFlash($category)): ?>
								<div class="flash-messenger">
								<div class="flash-<?php echo $category; ?>">
									<?php echo Yii::app()->getUser()->getFlash($category); ?>
								</div>
								</div>
								<?php endif; ?>
								<?php endforeach; ?>
							
							<?php endif; ?>
							<!-- /flash-messenger -->