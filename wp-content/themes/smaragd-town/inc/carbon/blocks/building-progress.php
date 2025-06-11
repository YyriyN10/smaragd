<?php


		if ( ! defined( 'ABSPATH' ) ) {
			exit;
		}

		use Carbon_Fields\Block;
		use Carbon_Fields\Field;

		add_action( 'carbon_fields_register_fields', 'building_progress' );

		function building_progress(){
			Block::make( 'Building progress' )
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
					Field::make_rich_text('text', 'Підзаголовок')
					     ->set_required(true)
					     ->set_width(50)
					     ->set_rows(1)
					     ->set_settings([
						     'media_buttons' => false,
						     'tinymce' => [
							     'toolbar1' => 'forecolor, bold, link',
							     'toolbar2' => '',

						     ],
					     ]),
					Field::make_complex('block_list', 'Перелік черг')
						->set_required(true)
						->add_fields(array(
							Field::make_text('step_name', 'Назва черги')
								->set_required(true)
								->set_width(20),
							Field::make_text('step_progress', 'Прогрес черги')
							     ->set_required(true)
							     ->set_attribute('type', 'number')
							     ->set_width(20),
							Field::make_text('progress_now', 'Що робиться зараз')
                ->set_required(true)
                ->set_width(60),
							Field::make_complex('inner_list', 'Що входить')
								->set_required(true)
								->add_fields(array(
									Field::make_text('name', 'Назва')
									     ->set_required(true)
                      ->set_width(40),
									Field::make_rich_text('text', 'Опис')
									     ->set_required(true)
                      ->set_width(60)
									     ->set_rows(1)
									     ->set_settings([
										     'media_buttons' => false,
										     'tinymce' => [
											     'toolbar1' => 'forecolor, bold, link',
											     'toolbar2' => '',

										     ],
									     ]),

						)),
						Field::make_media_gallery('media_gallery', 'Галерея зображень')
							     ->set_required(true)
							     ->set_type('image')
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
			     ->set_icon('chart-bar')

			     ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
				     ?>

				     <?php if( !empty( $fields['title'] ) ):?>

				         <section class="building-progress <?php if ( !empty( $fields['block_option_indent_top'] ) ){echo $fields['block_option_indent_top'];}?> <?php if ( !empty( $fields['block_option_indent_bottom'] ) ){echo $fields['block_option_indent_bottom'];}?> animation-tracking"

						     <?php if( !empty( $fields['block_option_anchor_id'] ) ):?>
							     id="<?php echo $fields['block_option_anchor_id'];?>"
						     <?php endif;?>

						     <?php if( !empty( $fields['block_options_bg_color'] ) || !empty( $fields['block_options_text_color'] )):?>
							     style="<?php if ( !empty( $fields['block_options_bg_color'] ) ){echo 'background-color: '.$fields['block_options_bg_color'].';';} if ( !empty( $fields['block_options_text_color'] ) ){echo 'color: '.$fields['block_options_text_color'].';';}?>"
						     <?php endif;?>
						     >
				           <div class="container">
                     <div class="row">
                       <div class="slider-wrapper col-lg-6">
                         <div class="slider" id="building-progress">

                         </div>
                       </div>
                       <div class="content col-lg-6">
                         <h2 class="block-title">
		                       <?php echo str_replace(['<p>', '</p>'], '', $fields['title'] );?>
                         </h2>
	                       <?php if( !empty($fields['text']) ):?>
                           <p class="sub-title">
			                       <?php echo str_replace(['<p>', '</p>'], '', $fields['text'] );?>
                           </p>
	                       <?php endif;?>
	                       <?php if( !empty($fields['block_list']) ):?>
                             <ul class="nav nav-tabs">
                               <?php foreach( $fields['block_list'] as $index=>$step ):?>
                                   <li class="nav-item">
                                     <a class="nav-link tub-btn" data-gallery="<?php echo implode(",", $step['media_gallery']);?>" data-bs-toggle="tab" href="#step-<?php echo $index;?>">
                                       <?php echo str_replace(['<p>', '</p>'], '', $step['step_name'] );?>
                                     </a>
                                   </li>
                               <?php endforeach;?>
                             </ul>

                             <div class="tab-content">
                             <?php foreach( $fields['block_list'] as $index=>$step ):?>
                                 <div class="tab-pane" id="step-<?php echo $index;?>">
                                   <div class="inner-content">
                                     <div class="progress-bar-wrapper">
                                       <p class="progress-now sub-title"><?php echo $step['progress_now'];?></p>
                                       <div class="progress-position" data-progress="<?php echo $step['step_progress'];?>">
                                         <p class="progress-indicator"><?php echo $step['step_progress'];?>%</p>
                                       </div>
                                     </div>
                                     <?php if( !empty($step['inner_list']) ):?>
                                       <ul class="card-list-wrapper">
                                         <?php foreach( $step['inner_list'] as $innerItem):?>
                                           <li class="card-item">
                                             <p class="name card-title"><?php echo str_replace(['<p>', '</p>'], '', $innerItem['name'] );?></p>
                                             <p class="description"><?php echo str_replace(['<p>', '</p>'], '', $innerItem['text'] );?></p>
                                           </li>
                                         <?php endforeach;?>
                                       </ul>
                                     <?php endif;?>
                                   </div>
                                 </div>
		                          <?php endforeach;?>
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
