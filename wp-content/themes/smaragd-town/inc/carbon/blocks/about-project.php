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
			     Field::make_file('block_video_mp4', 'Відео у форматі mp4')
			          ->set_width(50)
				        ->set_required(true)
			          ->set_type('video'),
			     Field::make_file('block_video_webm', 'Відео у форматі webm')
			          ->set_width(50)
			          ->set_required(true)
			          ->set_type('video'),


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
			          ->add_options( array(
				          'indent-top-big' => 'Великий відступ',
				          'indent-top-small' => 'Малкнький відступ',
			          ) ),
			     Field::make_select('block_option_indent_bottom', 'Розмір нижнього внутрішнього відступу')
			          ->add_options( array(
				          'indent-bottom-big' => 'Великий відступ',
				          'indent-bottom-small' => 'Малкнький відступ',
			          ) ),
			     Field::make_color('block_options_bg_color', 'Колір тла блоку')
			          ->set_palette( array( '#1201FF', '#F7F00F', '#F64B0A', '#F9F9F9', '#FFFDFC', '#1D1D1B', '#CFCFCF') ),

			     Field::make_color('block_options_text_color', 'Колір тексту')
			          ->set_palette( array( '#1201FF', '#F7F00F', '#F64B0A', '#F9F9F9', '#FFFDFC', '#1D1D1B', '#CFCFCF') ),

			     Field::make_text('block_option_anchor_id', 'Якір блоку')
				     ->set_help_text('Потрібен для посилання на цей блок на априклад якогось пункту меню чи кнопки. Може містити латинські літери, ціфри, тере та підкреслення. Має бути унікальним на одній сторінці. Не може містити пробілів')


		     ))
		     ->set_category( 'custom-category-home' )
		     ->set_icon('building')

		     ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
			     ?>

			     <?php if( !empty( $fields['title'] ) && !empty( $fields['text'] ) ):?>

				     <section class="about-me <?php if ( !empty( $fields['block_option_indent_top'] ) ){echo $fields['block_option_indent_top'];}?> <?php if ( !empty( $fields['block_option_indent_bottom'] ) ){echo $fields['block_option_indent_bottom'];}?> animation-tracking"

					     <?php if( !empty( $fields['block_option_anchor_id'] ) ):?>
						     id="<?php echo $fields['block_option_anchor_id'];?>"
					     <?php endif;?>

					     <?php if( !empty( $fields['block_options_bg_color'] ) || !empty( $fields['block_options_text_color'] )):?>
						     style="<?php if ( !empty( $fields['block_options_bg_color'] ) ){echo 'background-color: '.$fields['block_options_bg_color'].';';} if ( !empty( $fields['block_options_text_color'] ) ){echo 'color: '.$fields['block_options_text_color'].';';}?>"
					     <?php endif;?>
				     >
					     <div class="container">
						     <div class="row">
							     <div class="text-content col-lg-8">
								     <h2 class="block-title">
									     <?php echo str_replace(['<p>', '</p>'], '', $fields['title'] );?>
								     </h2>
								     <div class="text"><?php echo wpautop($fields['full_text']);?></div>
							     </div>
							     <?php if( !empty($fields['block_video_mp4']) && !empty($fields['block_video_webm']) ):?>
								     <div class="custom-video-wrapper col-lg-4">
									     <video class="custom-video" id="custom-video">
										     <source src="<?php echo $fields['block_video_webm'];?>" type="video/webm">
										     <source src="<?php echo $fields['block_video_mp4'];?>" type="video/mp4; codecs='hvc1'">
									     </video>
									     <div class="custom-video-player__controls-wrapper" id="video-controls">
										     <div class="video-progress">
											     <div class="video-progress__current"></div>
										     </div>
										     <button class="btn-play-pause" data-state="play" id="play-pause">Відтворити</button>
										     <input class="volume-control" type="range" id="volume-control" min="0" max="1" step="0.01" value="1">
										     <button class="btn-fullscreen" id="fullscreen">На весь екран</button>
									     </div>
								     </div>
							     <?php endif;?>
						     </div>
                 <?php if( $fields['block-list'] ):?>
                   <div class="row">
                     <ul class="card-list-wrapper col-12">
		                   <?php foreach( $fields['block-list'] as $item):?>
                         <li class="card-item">
                           <p class="name"><?php echo str_replace(['<p>', '</p>'], '', $item['name'] );?></p>
                           <p class="description"><?php echo str_replace(['<p>', '</p>'], '', $item['description'] );?></p>
                         </li>
		                   <?php endforeach;?>
                     </ul>
                   </div>
                 <?php endif;?>
					     </div>
				     </section>
			     <?php endif;?>

			     <?php
		     } );
	}
