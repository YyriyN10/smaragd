<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	use Carbon_Fields\Block;
	use Carbon_Fields\Field;

	add_action( 'carbon_fields_register_fields', 'about_us' );

	function about_us(){
		Block::make( 'About us' )
		     ->add_tab('Контент блоку', array(
			     Field::make_rich_text('title', 'Заголовок блоку')
			          ->set_required(true)
			          ->set_width(40)
			          ->set_rows(1)
			          ->set_settings([
				          'media_buttons' => false,
				          'tinymce' => [
					          'toolbar1' => 'forecolor',
					          'toolbar2' => '',

				          ],
			          ]),

			     Field::make_rich_text('full_text', 'Текст блоку')
			          ->set_required(true)
			          ->set_width(60)
			          ->set_settings([
				          'media_buttons' => false,
				          'tinymce' => [
					          'toolbar1' => 'forecolor',
				          ],

			          ]),
			     Field::make_image('company_logo', 'Логотип компанії')
			          ->set_width(50)
			          ->set_type('image')
			          ->set_value_type('url'),
			     Field::make_rich_text('slogan', 'Слоган')
			          ->set_width(50)
			          ->set_rows(1)
			          ->set_settings([
				          'media_buttons' => false,
				          'tinymce' => [
					          'toolbar1' => 'forecolor',
					          'toolbar2' => '',

				          ],
			          ]),
						Field::make_image('block_image', 'Зображення блоку')
			        ->set_required(true)
			        ->set_width(50),
			     Field::make_complex('block-list', 'Перелік переваг')
		          ->add_fields(array(
		          	Field::make_text('name', 'Назва')
			            ->set_required(true)
			            ->set_width(40),
			          Field::make_rich_text('description', 'Опис')
			               ->set_width(60)
			               ->set_required(true)
			               ->set_settings([
				               'media_buttons' => false,
				               'tinymce' => [
					               'toolbar1' => 'forecolor',
					               'toolbar2' => '',

				               ],
			               ]),

		          )),

		     ))
		     ->add_tab('Опції', array(
			     Field::make_select('block_option_indent_top', 'Розмір верхнього внутрішнього відступу')
			          ->set_width(50)
			          ->add_options( array(
				          'indent-top-big' => 'Великий відступ',
				          'indent-top-medium' => 'Середній відступ',
				          'indent-top-small' => 'Малкнький відступ',
			          ) ),
			     Field::make_select('block_option_indent_bottom', 'Розмір нижнього внутрішнього відступу')
			          ->set_width(50)
			          ->add_options( array(
				          'indent-bottom-big' => 'Великий відступ',
				          'indent-bottom-medium' => 'Середній відступ',
				          'indent-bottom-small' => 'Малкнький відступ',
			          ) ),

			     Field::make_color('block_options_bg_color', 'Колір тла блоку')
			          ->set_width(50)
			          ->set_palette( array( '#F9FCF5', '#F9FCF5', '#034F43', '#02B513', '#F2682C') ),

			     Field::make_color('block_options_text_color', 'Колір тексту')
			          ->set_width(50)
			          ->set_palette( array( '#F9FCF5', '#F9FCF5', '#034F43', '#02B513', '#F2682C') ),

			     Field::make_text('block_option_anchor_id', 'Якір блоку')
			          ->set_help_text('Потрібен для посилання на цей блок на априклад якогось пункту меню чи кнопки. Може містити латинські літери, ціфри, тере та підкреслення. Має бути унікальним на одній сторінці. Не може містити пробілів')


		     ))
		     ->set_category( 'custom-category-home' )
		     ->set_icon('admin-home')

		     ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
			     ?>

			     <?php if( !empty( $fields['title'] )  ):?>

				     <section class="about-us <?php if ( !empty( $fields['block_option_indent_top'] ) ){echo $fields['block_option_indent_top'];}?> <?php if ( !empty( $fields['block_option_indent_bottom'] ) ){echo $fields['block_option_indent_bottom'];}?> animation-tracking"

					     <?php if( !empty( $fields['block_option_anchor_id'] ) ):?>
						     id="<?php echo $fields['block_option_anchor_id'];?>"
					     <?php endif;?>

					     <?php if( !empty( $fields['block_options_bg_color'] ) || !empty( $fields['block_options_text_color'] )):?>
						     style="<?php if ( !empty( $fields['block_options_bg_color'] ) ){echo 'background-color: '.$fields['block_options_bg_color'].';';} if ( !empty( $fields['block_options_text_color'] ) ){echo 'color: '.$fields['block_options_text_color'].';';}?>"
					     <?php endif;?>
				     >
					     <div class="container">
                 <div class="row">
                   <h2 class="block-title col-12 text-center">
		                 <?php echo str_replace(['<p>', '</p>'], '', $fields['title'] );?>
                   </h2>
                 </div>
						     <div class="row">
							     <div class="block-image col-lg-4">
                     <div class="image-wrapper">
                       <img
                           class="lazy object-fit"
                           data-src="<?php echo wp_get_attachment_image_src($fields['block_image'], 'full')[0];?>"
		                     <?php
			                     $altText = get_post_meta($fields['block_image'], '_wp_attachment_image_alt', TRUE);
			                     if ( !empty( $altText ) ):?>
                             alt="<?php echo $altText;?>"
			                     <?php else:?>
                             alt="<?php echo wp_strip_all_tags($fields['title']);?>"
			                     <?php endif;?>

                       >
                     </div>
							     </div>
                   <div class="text-content col-lg-8">
                     <?php if( !empty($fields['company_logo']) ):?>
                       <img src="<?php echo $fields['company_logo'];?>" alt="<?php echo get_bloginfo('name');?>" class="svg-pic">
                     <?php endif;?>

                     <div class="text"><?php echo wpautop($fields['full_text']);?></div>
                   </div>
						     </div>
						     <?php if( $fields['block-list'] ):?>
							     <div class="row">
								     <ul class="card-list-wrapper col-12">
									     <?php foreach( $fields['block-list'] as $item):?>
										     <li class="card-item">
											     <p class="name card-title big-title"><?php echo str_replace(['<p>', '</p>'], '', $item['name'] );?></p>
											     <p class="description card-title"><?php echo str_replace(['<p>', '</p>'], '', $item['description'] );?></p>
										     </li>
									     <?php endforeach;?>
								     </ul>
							     </div>
						     <?php endif;?>
					     </div>
					     <?php if( !empty($fields['slogan']) ):?>
                 <p class="slogan block-title text-center"><?php echo str_replace(['<p>', '</p>'], '', $fields['slogan'] );?></p>
					     <?php endif;?>
				     </section>
			     <?php endif;?>

			     <?php
		     } );
	}
