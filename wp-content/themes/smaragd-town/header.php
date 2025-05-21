<?php
  if ( ! defined( 'ABSPATH' ) ) {
  			exit;
  		}
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package smaragd-town
 */

$site_logo = carbon_get_theme_option('option_site_logo');

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

  <meta name="msapplication-TileColor" content="#16246F">
  <meta name="theme-color" content="#16246F">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="wrapper">
	<header class="site-header">
    <div class="container">
      <div class="row">
        <div class="content col-12">
          <?php if( !empty($site_logo) ):?>
	          <?php if( is_front_page() ):?>
              <div class="logo">
                <img src="<?php echo $site_logo;?>" alt="<?php echo get_bloginfo('name');?>" class="svg-pic">
              </div>
	          <?php else:?>
              <a href="<?php echo get_home_url('/');?>" class="logo">
                <img src="<?php echo $site_logo;?>" alt="<?php echo get_bloginfo('name');?>" class="svg-pic">
              </a>
	          <?php endif;?>
          <?php endif;?>

          <nav class="header-navigation">
            <button class="menu-btn" id="menu-btn">
              <span></span><span></span><span></span>
            </button>
		        <?php
			        wp_nav_menu(
				        array(
					        'theme_location' => 'menu-1',
					        'menu_id'        => 'main-menu',
                  'menu_class'     => 'main-menu',
                  'container'      => false
				        )
			        );
		        ?>
	          <?php get_template_part('template-parts/social');?>
	          <?php get_template_part('template-parts/phone');?>
	          <?php get_template_part('template-parts/email');?>
          </nav>
	        <?php get_template_part('template-parts/phone');?>
        </div>
      </div>
    </div>
	</header>
  <main>
