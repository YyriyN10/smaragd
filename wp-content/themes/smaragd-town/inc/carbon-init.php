<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	/**
	 * Add Carbon Fields
	 */

	add_action( 'after_setup_theme', 'carbon_load' );

	function carbon_load() {
		require get_template_directory() . '/vendor/autoload.php';
		\Carbon_Fields\Carbon_Fields::boot();
	}

	/**
	 * WPML Support
	 */

	function yuna_lang_prefix() {
		$prefix = '';
		if ( ! defined( 'ICL_LANGUAGE_CODE' ) ) {
			return $prefix;
		}

		$prefix = '_' . ICL_LANGUAGE_CODE;
		return $prefix;
	}

	/**
	 * Create Block Category
	 */
	

	add_filter( 'block_categories_all' , function( $categories ) {

		$categories[] = array(
			'slug'  => 'custom-category-home',
			'title' => 'Блоки головної сторінки',
			'icon'  => 'admin-home'
		);

		return $categories;
	} );

	/**
	 * Add blocks
	 */
	require ('carbon/blocks/home-main-screen.php');
	require( 'carbon/blocks/about-project.php' );
	require ('carbon/blocks/life-space.php');
	require ('carbon/blocks/location.php');
	require ('carbon/blocks/call-to-action.php');
	require ('carbon/blocks/infrastructure.php');
	require ('carbon/blocks/building-types.php');
	require ('carbon/blocks/building-progress.php');
	require ('carbon/blocks/gallery.php');
	require ('carbon/blocks/about-us.php');


	/**
	 * Add templates
	 */
	require ('carbon/pages/option-page.php');