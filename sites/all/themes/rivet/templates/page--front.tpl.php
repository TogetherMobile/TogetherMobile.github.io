<!--.page -->
<div role="document" class="page">
	<?php if (drupal_is_front_page()) : ?><div id="video-bg" class=""></div><?php endif; ?>
	
	<header role="banner" class="header<?php print (!drupal_is_front_page() ? ' fixed' : '')?>">
	    <nav class="top-bar">
	    	<div class="row">
		    	<div class="column">
					<ul class="title-area">
			    		<li>
			    			<a href="<?php print drupal_is_front_page() ? '#home' : '/'; ?>">
					    		<img src="<?php print theme_get_setting('logo'); ?>" alt="<?php print $site_name; ?>" />
							</a>
						</li>
					    <li class="menu-icon"><a href="#"><span></span></a></li>
					</ul>
					
					<?php //if (!empty($page['header'])) { print render($page['header']); } ?>			    	
					<?php 
						$block = module_invoke('block', 'block_view', '1');
						print '<div class="block block-block block-block-1">' . render( $block['content'] ) . '</div>';						
					?>
		    	</div>
	    	</div>
			
			<section class="top-bar-section">
				<div class="row">
					<div class="column">
						<?php print _build_nav('main-menu', false); ?>
					</div>
				</div>
			</section>
	    </nav>
	</header><!--/.header -->
	
	<?php if ($messages && !$zurb_foundation_messages_modal): ?>
	<section class="messages row">
		<div class="large-12 column"><?php if ($messages): print $messages; endif; ?></div>
	</section><!--/.messages -->
	<?php endif; ?>
	
	<main role="main">
		<?php if (!empty($page['featured'])): ?>
		<?php print render( $page['featured'] ); ?>
		<?php endif; ?>
		
			<?php if (!drupal_is_front_page()) : ?><div class="row"><div class="column"><?php endif; ?>
		
				<?php if ( $title && !$is_front && !isset($node) ): ?>
			    	<?php print render($title_prefix) . '<h1 id="page-title" class="title">' . $title . '</h1>' . render($title_suffix); ?>
			    <?php endif; ?>
			    <?php if (!empty($tabs)): print render($tabs); endif; ?>
			    <?php if (!empty($tabs2)): print render($tabs2); endif; ?>
			    <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
			    <?php print render($page['content']); ?>
			<?php if (!drupal_is_front_page()) : ?></div></div><?php endif; ?>

		
		<footer id="footer" class="footer" role="contentinfo">
			<div class="row">
				<div class="column medium-3">
			  		<a href="<?php print drupal_is_front_page() ? '#home' : '/'; ?>" class="logo">
		    			<img src="<?php print theme_get_setting('logo'); ?>" alt="<?php print $site_name; ?>" />
		    		</a>
		    		
					<?php
				  		$block = module_invoke('block', 'block_view', '2');
				  		print '<div class="block block-block block-block-social">' . 
								render( $block['content'] ) . 
							  '</div>';
					?>
			  	</div>
			  	<div class="footer-content column medium-9 medium-push-1">
			  		<?php print _build_nav('menu-footer', false); ?>
			  	</div>
			</div>
			<div class="row">
		  		
			</div>
		  	<div class="row copy">
			  	<div class="column medium-6">
			  		&copy; <?php print date('Y') . ' ' . check_plain($site_name) . ' ' . t('All rights reserved.'); ?>
			  	</div>
			  	<div class="column medium-6 text-right">
			  		<a href="http://legal.rivet.works/privacy.html">Privacy Policy</a>
			  	</div>
		  	</div>

		</footer><!--/.footer-->
	</main><!--/main-->
	
	<?php if ($messages && $zurb_foundation_messages_modal): print $messages; endif; ?>
</div>
<div id="page-hidden"><?php print render( $page['page_hidden'] ); ?></div>