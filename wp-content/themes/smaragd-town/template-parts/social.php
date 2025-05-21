<?php

	if ( ! defined( 'ABSPATH' ) ) {
				exit;
			}

	$social_list = carbon_get_theme_option('option_site_social_networks');

	if (!empty($social_list)):?>
		<ul class="social-wrapper">
			<?php foreach( $social_list as $social ):?>
				<li class="item">
					<a href="<?php echo $social['link'];?>" rel="nofollow" target="_blank">
						<img src="<?php echo $social['icon'];?>" alt="<?php echo $social['name'];?>" class="svg-pic">
					</a>
				</li>
			<?php endforeach;?>
		</ul>
<?php endif;?>
