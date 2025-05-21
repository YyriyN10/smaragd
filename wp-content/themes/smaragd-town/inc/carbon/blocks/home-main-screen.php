<?php

		if ( ! defined( 'ABSPATH' ) ) {
			exit;
		}

		use Carbon_Fields\Block;
		use Carbon_Fields\Field;

		add_action( 'carbon_fields_register_fields', 'home_main_screen' );

		function home_main_screen(){
			Block::make( 'Home main screen' )
				->add_tab('Контент блоку', array(
					Field::make_rich_text('title', 'Заголовок блоку')
					     ->set_required(true)
							 ->set_width(50)
					     ->set_rows(1)
					     ->set_settings([
						     'media_buttons' => false,
						     'tinymce' => [
							     'toolbar1' => 'forecolor',
							     'toolbar2' => '',

						     ],
					     ]),
					Field::make_rich_text('text', 'Текст блоку')
					     ->set_rows(1)
					     ->set_width(50)
					     ->set_settings([
						     'media_buttons' => false,
						     'tinymce' => [
							     'toolbar1' => 'forecolor, bold, link',
							     'toolbar2' => '',

						     ],
					     ]),
					Field::make_text('btn_text', 'Текст кнопки')
						->set_width(50),
          Field::make_image('bg-image', 'Фонове зображення')
            ->set_width(50)

				))
			     ->add_tab('Опції', array(

				     Field::make_color('block_options_bg_color', 'Колір тла блоку')
				          ->set_palette( array( '#1201FF', '#F7F00F', '#F64B0A', '#F9F9F9', '#FFFDFC', '#1D1D1B', '#CFCFCF') ),

				     Field::make_color('block_options_text_color', 'Колір тексту')
				          ->set_palette( array( '#1201FF', '#F7F00F', '#F64B0A', '#F9F9F9', '#FFFDFC', '#1D1D1B', '#CFCFCF') ),

				     Field::make_select('block_option_btn_color', 'Колір кнопки')
				          ->add_options( array(
					          'red' => 'Червоний',
					          'black' => 'Чорний',
				          ) ),

			     ))
			     ->set_category( 'custom-category-home' )
			     ->set_icon('cover-image')

			     ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
				     ?>

				     <?php if( !empty( $fields['title'] ) ):?>

				         <section class="main-screen home-main-screen"

						     <?php if( !empty( $fields['block_options_bg_color'] ) || !empty( $fields['block_options_text_color'] )):?>
							     style="<?php if ( !empty( $fields['block_options_bg_color'] ) ){echo 'background-color: '.$fields['block_options_bg_color'].';';} if ( !empty( $fields['block_options_text_color'] ) ){echo 'color: '.$fields['block_options_text_color'].';';}?>"
						     <?php endif;?>
						     >
                   <?php if( !empty($fields['bg-image']) ):?>
                     <div class="bg-img">
                       <img
                           src="<?php echo wp_get_attachment_image_src($fields['bg-image'], 'full')[0];?>"
			                   <?php
				                   $altText = get_post_meta($fields['bg-image'], '_wp_attachment_image_alt', TRUE);
				                   if ( !empty( $altText ) ):?>
                             alt="<?php echo $altText;?>"
				                   <?php else:?>
                             alt="<?php echo get_bloginfo('name');?>"
				                   <?php endif;?>

                       >
                     </div>
                   <?php endif;?>

				           <div class="container">
				             <div class="row">
					             <div class="content col-12">
						             <h1 class="block-title">
							             <?php echo str_replace(['<p>', '</p>'], '', $fields['title'] );?>
						             </h1>
                         <?php if( !empty($fields['text']) ):?>
                           <p class="main-text"><?php echo str_replace(['<p>', '</p>'], '', $fields['text'] );?></p>
                         <?php endif;?>
						             <?php if ( !empty( $fields['btn_text'] ) ):?>
							             <div class="button <?php if ( !empty( $fields['block_option_btn_color'] ) ){echo $fields['block_option_btn_color'].'-btn';}else{echo 'basic-btn';}?>" data-bs-toggle="modal" data-bs-target="#formModal">
								             <?php echo $fields['btn_text'];?>
							             </div>
						             <?php endif;?>
					             </div>
				             </div>
				           </div>
				         </section>
				     <?php endif;?>

				     <?php
			     } );
		}
