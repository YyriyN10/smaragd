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
							Field::make_complex('inner_list', 'Що входить')
								->set_required(true)
								->set_width(60)
								->add_fields(array(
									Field::make_image('icon', 'Іконка')
										->set_required(true),
									Field::make_text('name', 'Назва')
									     ->set_required(true),
									Field::make_rich_text('text', 'Опис')
									     ->set_required(true)
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
				               <h2 class="block-title col-12">
					               <?php echo str_replace(['<p>', '</p>'], '', $fields['title'] );?>
				               </h2>
					             <?php if( !empty($fields['text']) ):?>
						             <p class="subtitle">
							             <?php echo str_replace(['<p>', '</p>'], '', $fields['text'] );?>
						             </p>
					             <?php endif;?>
				             </div>
					           <?php if( !empty($fields['block_list']) ):?>
						           <div class="row">
												<?php foreach( $fields['block_list'] as $index=>$step ):?>
													<ul class="nav nav-tabs">
														<li class="nav-item">
															<a class="nav-link" data-bs-toggle="tab" href="#step-<?php echo $index;?>">
																<?php echo str_replace(['<p>', '</p>'], '', $step['step_name'] );?>
															</a>
														</li>
													</ul>
												<?php endforeach;?>
												<?php foreach( $fields['block_list'] as $index=>$step ):?>
													<div class="tab-content">
														<div class="tab-pane fade" id="step-<?php echo $index;?>">
															<div class="inner-content">
																<div class="progres-bar-wrapper">
																	<div class="progress-position" data-progress="<?php echo $step['step_progress'];?>"></div>
																</div>
																<?php if( !empty($step['inner_list']) ):?>
																	<ul class="card-list-wrapper">
																		<?php foreach( $fields['inner_list'] as $innerItem):?>
																			<li class="card-item">
																				<div class="icon-wrapper">
																					<img src="<?php echo $innerItem['icon'];?>" alt="<?php echo wp_strip_all_tags($innerItem['name']);?>" class="svg-pic">
																				</div>
																				<p class="name"><?php echo str_replace(['<p>', '</p>'], '', $innerItem['name'] );?></p>
																				<p class="description"><?php echo str_replace(['<p>', '</p>'], '', $innerItem['text'] );?></p>
																			</li>

																		<?php endforeach;?>
																	</ul>
																<?php endif;?>
																<?php if( !empty($step['media_gallery']) ):?>
																	<div class="media-gallery">
																		<?php foreach( $step['media_gallery'] as $image ):?>
																			<div class="slide">
																				<img
																				   src="<?php echo wp_get_attachment_image_src($image['id'], 'full')[0];?>"
																				   <?php
																				    $altText = get_post_meta($image['id'], '_wp_attachment_image_alt', TRUE);
																				    if ( !empty( $altText ) ):?>
																				        alt="<?php echo $altText;?>"
																				    <?php else:?>
																				        alt="<?php echo wp_strip_all_tags($step['step_name']);?>"
																				    <?php endif;?>

																				>
																			</div>
																		<?php endforeach;?>
																	</div>
																<?php endif;?>
															</div>
														</div>

													</div>
												<?php endforeach;?>

						           </div>
					           <?php endif;?>

				           </div>
				         </section>
				     <?php endif;?>

				     <?php
			     } );
		}
