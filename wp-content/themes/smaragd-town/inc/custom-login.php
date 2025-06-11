<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	/**
	 * Редирект на головну із site.com/wp-admin
	 */
	add_action( 'init', function () {
		if ( is_admin() && ! current_user_can( 'administrator' ) &&
		     ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
			wp_redirect( home_url() );
			exit;
		}
	});

	/**
	 * Редирект на головну із site.com/wp-login.php
	 */
	add_action( 'init', function () {
		$page_viewed = basename( $_SERVER['REQUEST_URI'] );
		if ( $page_viewed == "wp-login.php" ) {
			wp_redirect( home_url() );
			exit;
		}
	});

	/**
	 * Редирект на головну після виходу із системи
	 */
	add_action( 'wp_logout', function () {
		$login_page  = home_url( 'wp-admin' );
		wp_redirect( $login_page . "?loggedout=true" );
		exit;
	});

	add_filter( 'login_headertext', 'yuna_change_login_logo_text' );

	function yuna_change_login_logo_text( $text ) {
		$login_logo_text = carbon_get_theme_option('option_login_page_site_name');

		if (!empty($login_logo_text)){
			return $login_logo_text;
		}else{
			return 'Увійти в адмін пвнель';
		}

	}

	add_action( 'login_head', 'yuna_no_login_logo' );

	function yuna_no_login_logo() {

		$login_accent_color = carbon_get_theme_option('option_login_page_accent_color');
		$login_bg_color = carbon_get_theme_option('option_login_page_bg_color');
		$login_image_logo = carbon_get_theme_option('option_login_page_logo_image');

		if (empty($login_accent_color)){
			$login_accent_color = '#0000ff';
		}

		if (empty($login_bg_color)){
			$login_bg_color = '#ffff00';
		}

		if (empty($login_image_logo)){
			echo '<style>
				#login h1 a {
			    background-image: none;
			    text-indent: 0;
			    height: auto;
			    width: auto;
			    color: '.$login_accent_color.';
			    font-size: 38px;
			    font-weight: 700;
				}
				
				
			</style>';
		}else{
			echo '<style>
				#login h1 a {
			    background-image: url('.$login_image_logo.');
			    height: 60px;
			    width: auto;
			    background-size: contain;
			    border: none !important;
				}
				
				#login h1 a:hover,
				#login h1 a:focus{
					color: rgba(0,0,0,0) !important;
					border: none !important;
					outline: none !important;
				}
				
				#login h1{
					outline: none !important;
				}
				
				
				</style>';
		}

		echo'<style>
#login form{
					box-shadow: none !important;
					border: 2px solid '.$login_accent_color.';
					background-color: '.$login_bg_color.';
					color: '.$login_accent_color.';
				}
				
				#login form input{
					background-color: '.$login_bg_color.';
					border: 1px solid #000;
					color: '.$login_accent_color.';
					font-size: 14px;
					padding-left: 20px;
				}
				
				#login form input::-webkit-input-placeholder {
		        color: '.$login_accent_color.';
		      }
		      #login form input:-moz-placeholder {
		        color: '.$login_accent_color.';
		      }
		      #login form input::-moz-placeholder {
		        color: '.$login_accent_color.';
		      }
		      #login form input:-ms-input-placeholder {
		        color: '.$login_accent_color.';
		      }
				
				#login form input:focus{
					border: 1px solid '.$login_accent_color.';
					box-shadow: none !important;
					outline: none;
				}
				
				#login form p.submit{
					width: 100%;
					display: flex;
					padding-top: 20px;
					justify-content: center;
				}
				
				#login form p.submit .button{
					display: inline-block;
					padding: 	5px 30px;
					background-color: '.$login_accent_color.';
					font-size: 18px;
					border: 1px solid '.$login_accent_color.';
					width: 100%;
					color: '.$login_bg_color.';
					transition: all 0.5s;
				
				}
				
				#login form p.submit .button:hover{
				border: 1px solid rgba(255,255,255,0.7);
				}
				
				#login #nav,
				#login #nav a,
				#backtoblog a{
					color: '.$login_accent_color.';
				}
				
				.login #backtoblog a{
					color: '.$login_accent_color.';
				}
				
				.login{
					background-color: '.$login_bg_color.';
				}
				
				.language-switcher{
					display: none;
				}
		</style>';




	}

	add_filter( 'login_headerurl', 'yuna_login_link_to_website' );

	function yuna_login_link_to_website( $url ) {
		return site_url();
	}