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
          <div class="header-info">
            <div class="icon-wrapper">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.72677 5.68745C5.08953 7.32468 4.85061 9.77766 6.21424 11.4683C7.01305 12.4587 7.97305 13.5588 9.07107 14.6569C10.1691 15.7549 11.2692 16.7149 12.2596 17.5137C13.9503 18.8773 16.4032 18.6384 18.0405 17.0012C18.1636 16.878 18.1636 16.6783 18.0405 16.5552L16.034 14.5488C15.83 14.3447 15.5084 14.3181 15.2736 14.4858C14.0803 15.3382 12.4456 15.2029 11.4086 14.1659L9.56198 12.3193C8.52499 11.2824 8.3897 9.64766 9.2421 8.4543C9.4098 8.21952 9.38318 7.8979 9.17917 7.69388L7.17273 5.68745C7.04958 5.5643 6.84992 5.5643 6.72677 5.68745ZM6.01966 4.98034C6.53333 4.46667 7.36616 4.46667 7.87983 4.98034L9.88627 6.98678C10.436 7.53646 10.5077 8.40297 10.0558 9.03554C9.48757 9.83111 9.57776 10.9209 10.2691 11.6122L12.1157 13.4588C12.807 14.1502 13.8968 14.2404 14.6924 13.6721C15.3249 13.2203 16.1915 13.292 16.7411 13.8416L18.7476 15.8481C19.2613 16.3618 19.2613 17.1946 18.7476 17.7083C16.8008 19.6551 13.7748 20.0205 11.6318 18.292C10.619 17.4751 9.49146 16.4915 8.36396 15.364C7.23646 14.2365 6.25279 13.109 5.43587 12.0961C3.7074 9.95312 4.07285 6.92715 6.01966 4.98034Z" fill="#F9FCF5"/>
              </svg>
            </div>
            <div class="info-list">
	            <?php get_template_part('template-parts/phone');?>
	            <?php get_template_part('template-parts/schedule');?>
            </div>
          </div>

        </div>
      </div>
    </div>
	</header>
  <main>
