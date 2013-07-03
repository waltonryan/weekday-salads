<?php
/**
 * Display the copyright, and custom menu.
 *
 * @package Foodie
 * @since Foodie 1.0
 */
?>

			<footer id="colophon" class="site-footer" role="contentinfo">
				<div class="site-info">
					<div class="copyright">
						<?php do_action( 'foodie_credits' ); ?>
						<?php echo apply_filters( 'foodie_copyright', sprintf( '&copy; %1$s %2$s. <small>Powered by <a href="%3$s">WordPress</a> - Foodie Theme by <a href="%4$s">Mint Themes</a></small>', date( 'Y' ), get_bloginfo( 'name' ), 'http://wordpress.org', 'http://mintthemes.com' ) ); ?>
						<?php wp_nav_menu( array( 'theme_location' => 'footer', 'depth' => 1 ) ); ?>
					</div>
					<?php if ( 'on' == foodie_get_theme_option( 'display_metrics' ) ) : ?>
					<div class="vanity">
						<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo urlencode( home_url() ); ?>&amp;send=false&amp;layout=button_count&amp;width=90&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=131290840236497" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:21px;" allowTransparency="true"></iframe>
						
						<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo urlencode( home_url() ); ?>">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

						<a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode( home_url() ); ?>&media=<?php echo urlencode( home_url() ); ?>&description=<?php bloginfo( 'description' ); ?>" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
						<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
					</div>
					<?php endif; ?>
				</div><!-- .site-info -->
			</footer><!-- .site-footer .site-footer -->