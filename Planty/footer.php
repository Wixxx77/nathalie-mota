<?php
/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?>
			<footer id="site-footer" class="header-footer-group">
			<div id="nous-contacter" class="modal">
			<span class="close"><i class="fa-solid fa-x"></i></span>
    <div class="modal-content">
        <!-- Ton contenu ici --><img class="entete-form" src="/wp-content/uploads/2025/03/logo-contact-header.webp" />
		  <?php echo do_shortcode('[fluentform id="3"]'); ?>
    </div>
</div>

			
				<div class="section-inner">
					<a href="http://mota-reussite.local/mentions-legale/" class="footer-item"> MENTIONS LÉGALES</a>
					<a href="http://mota-reussite.local/vie-privee/" class="footer-item" >  VIE PRIVÉE</a>
					<H3 class="footer-item">  TOUS DROITS RÉSERVÉS</H3>
				</div><!-- .section-inner -->

			</footer><!-- #site-footer -->

		<?php wp_footer(); ?>

	</body>
</html>
