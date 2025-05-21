<?php
  if ( ! defined( 'ABSPATH' ) ) {
  			exit;
  		}
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package smaragd-town
 */

?>
</main>
	<footer class="site-footer">
		<div class="container">
      <div class="row">
        <div class="footer-contacts col-lg-6">
          <?php
            $footer_contacts_title = carbon_get_theme_option('option_site_footer_contacts_title');
	          $footer_social_title = carbon_get_theme_option('option_site_footer_social_title');
	          $footer_sale_address = carbon_get_theme_option('option_sales_address');
	          $footer_work_schedule = carbon_get_theme_option('option_work_schedule');
          ?>
          <div class="contacts">
            <?php if( !empty($footer_contacts_title) ):?>
              <h3><?php echo $footer_contacts_title;?></h3>
            <?php endif;?>
            <?php if( !empty($footer_sale_address) ):?>
              <p class="contact-item"><?php echo $footer_sale_address;?></p>
            <?php endif;?>
	          <?php if( !empty($footer_work_schedule) ):?>
              <p class="contact-item"><?php echo $footer_work_schedule;?></p>
	          <?php endif;?>
            <?php get_template_part('template-parts/phone');?>
	          <?php get_template_part('template-parts/email');?>
          </div>
          <div class="social">
	          <?php if( !empty($footer_social_title) ):?>
              <h3><?php echo $footer_social_title;?></h3>
	          <?php endif;?>
            <?php get_template_part('template-parts/social');?>
          </div>
        </div>
        <div class="footer-form-wrapper col-lg-6">
          <?php
            $footer_form_title = carbon_get_theme_option('option_site_footer_form_title');
	          $footer_form_subtitle = carbon_get_theme_option('option_site_footer_form_sub_title');
	          $footer_form_btn_text = carbon_get_theme_option('option_site_footer_form_btn_text');

	          if (!empty($footer_form_title)):
          ?>
            <h3><?php echo $footer_form_title;?></h3>
          <?php endif;?>
          <?php if( !empty($footer_form_subtitle) ):?>
            <p><?php echo $footer_form_subtitle;?></p>
          <?php endif;?>

          <?php if( !empty($footer_form_btn_text) ): ?>
            <?php
              $form_args = array(
                  'btn_text' => $footer_form_btn_text,
                'btn_color' => '',
              );
            get_template_part('template-parts/form', null, $form_args);?>
          <?php endif;?>
        </div>
      </div>
      <div class="row">
        <div class="copy-wrapper text-center col-12">
          <p class="copy">©<?php echo date('Y');?> <?php echo carbon_get_theme_option('option_site_copy_text');?></p>
          <p class="dev-by">Сайт розроблено <a href="https://smmstudio.com/" rel="nofollow" target="_blank">SMMSTUDIO</a></p>
        </div>
      </div>
    </div>
	</footer>
</div>

<?php wp_footer(); ?>

</body>
</html>
