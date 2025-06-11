<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	use Carbon_Fields\Block;
	use Carbon_Fields\Field;

	add_action( 'carbon_fields_register_fields', 'about_project' );

	function about_project(){
		Block::make( 'About project' )
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
			          ]),
			     Field::make_file('block_video', 'Відео')
			          ->set_width(50)
				        ->set_required(true)
			          ->set_type('video'),
			     Field::make_image('block_video_preview', 'Постер для відео')
			          ->set_width(50)
			          ->set_required(true)
			          ->set_type('image'),


			     Field::make_complex('block_list', 'Про нас в тезах')
			      ->add_fields(array(
				      Field::make_rich_text('name', 'Теза')
				           ->set_width(40)
				           ->set_settings([
					           'media_buttons' => false,
				           ]),
				      Field::make_rich_text('text', 'Значення')
				           ->set_required(true)
				           ->set_width(60)
				           ->set_rows(1)
				           ->set_settings([
					           'media_buttons' => false,
					           'tinymce' => [
						           'toolbar1' => 'forecolor',
						           'toolbar2' => '',

					           ],
				           ]),
			      ))


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
		     ->set_icon('building')

		     ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
			     ?>

			     <?php if( !empty( $fields['title'] )  ):?>

				     <section class="about-project <?php if ( !empty( $fields['block_option_indent_top'] ) ){echo $fields['block_option_indent_top'];}?> <?php if ( !empty( $fields['block_option_indent_bottom'] ) ){echo $fields['block_option_indent_bottom'];}?> animation-tracking"

					     <?php if( !empty( $fields['block_option_anchor_id'] ) ):?>
						     id="<?php echo $fields['block_option_anchor_id'];?>"
					     <?php endif;?>

					     <?php if( !empty( $fields['block_options_bg_color'] ) || !empty( $fields['block_options_text_color'] )):?>
						     style="<?php if ( !empty( $fields['block_options_bg_color'] ) ){echo 'background-color: '.$fields['block_options_bg_color'].';';} if ( !empty( $fields['block_options_text_color'] ) ){echo 'color: '.$fields['block_options_text_color'].';';}?>"
					     <?php endif;?>
				     >
					     <div class="container">
						     <div class="row">
                   <div class="video-preview col-lg-6">
                     <div class="inner">
                       <img
                          class="lazy object-fit"
                          data-src="<?php echo wp_get_attachment_image_src($fields['block_video_preview'], 'full')[0];?>"
                          <?php
                           $altText = get_post_meta($fields['block_video_preview'], '_wp_attachment_image_alt', TRUE);
                           if ( !empty( $altText ) ):?>
                               alt="<?php echo $altText;?>"
                           <?php else:?>
                               alt="<?php echo wp_strip_all_tags($fields['title']);?>"
                           <?php endif;?>

                       >
                       <button class="play" data-video-src="<?php echo $fields['block_video'];?>">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                           <path d="M7.00491 6.71996C7.09855 5.35909 8.57374 4.53683 9.7803 5.17308L9.89944 5.24144L18.0616 10.2922C19.327 11.0751 19.3249 12.9157 18.0576 13.6955L9.89554 18.718C8.66916 19.4725 7.10161 18.6416 7.00491 17.2375L7.00003 17.0998V6.85766L7.00491 6.71996ZM8.00003 17.0998C8.00003 17.8038 8.77152 18.2351 9.37112 17.8664L17.5332 12.844C18.1271 12.4786 18.1659 11.6472 17.6475 11.2219L17.5362 11.1418L9.37308 6.09203C8.77356 5.72144 8.00006 6.15275 8.00003 6.85766V17.0998Z" fill="#F9FCF5"/>
                         </svg>
                       </button>
                     </div>
                   </div>
							     <div class="text-content col-lg-6">
								     <h2 class="block-title">
									     <?php echo str_replace(['<p>', '</p>'], '', $fields['title'] );?>
								     </h2>
								     <div class="text"><?php echo wpautop($fields['full_text']);?></div>
								     <?php if( !empty($fields['block_list']) ):?>
                       <ul class="card-list-wrapper">
										     <?php foreach( $fields['block_list'] as $item):?>
                           <li class="card-item">
                             <p class="name card-title big-title"><?php echo str_replace(['<p>', '</p>'], '', $item['name'] );?></p>
                             <p class="description sub-title"><?php echo str_replace(['<p>', '</p>'], '', $item['text'] );?></p>
                           </li>
										     <?php endforeach;?>
                       </ul>
								     <?php endif;?>
							     </div>
						     </div>
					     </div>
				     </section>
			     <?php endif;?>

			     <?php
		     } );
	}
