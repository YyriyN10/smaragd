<?php

		if ( ! defined( 'ABSPATH' ) ) {
			exit;
		}

		use Carbon_Fields\Block;
		use Carbon_Fields\Field;

		add_action( 'carbon_fields_register_fields', 'call_to_action' );

		function call_to_action(){
			Block::make( 'Call to action' )
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
					Field::make_rich_text('text', 'Текст заклику')
					     ->set_width(50)
					     ->set_rows(1)
					     ->set_settings([
						     'media_buttons' => false,
						     'tinymce' => [
							     'toolbar1' => 'forecolor, bold, link',
							     'toolbar2' => '',

						     ],
					     ]),
					Field::make_text('btn_text', 'Текст кнопки')
            ->set_width(40),
          Field::make_image('block_logo', 'Зображення логотипу')
            ->set_width(30)
            ->set_value_type('url')
            ->set_type('image'),
					Field::make_image('bg_image', 'Зображення фону')
					     ->set_width(30)
					     ->set_type('image'),
				))
			     ->add_tab('Опції', array(

				     Field::make_color('block_options_bg_color', 'Колір тла блоку')
                ->set_width(50)
				          ->set_palette( array( '#F9FCF5', '#F9FCF5', '#034F43', '#02B513', '#F2682C') ),

				     Field::make_color('block_options_text_color', 'Колір тексту')
					     ->set_width(50)
				          ->set_palette( array( '#F9FCF5', '#F9FCF5', '#034F43', '#02B513', '#F2682C') ),

				     Field::make_select('block_option_btn_color', 'Колір кнопки')
					     ->set_width(50)
				          ->add_options( array(
					          'orange' => 'Помаранчевий',
					          'green' => 'Зелений',
				          ) ),
				     Field::make_text('block_option_anchor_id', 'Якір блоку')
					     ->set_width(50)
				        ->set_help_text('Потрібен для посилання на цей блок на априклад якогось пункту меню чи кнопки. Може містити латинські літери, ціфри, тере та підкреслення. Має бути унікальним на одній сторінці. Не може містити пробілів'),
				     Field::make_radio('block_option_add_form', 'Варіант відображення блоку')
					     ->set_width(50)
					     ->set_required(true)
					     ->add_options( array(
						     'call-to-form' => 'Виводити форму у блоці',
						     'call-to-single' => 'Не виводити форму у блоці',

					     ) ),
             Field::make_select('block_option_content_alignment', 'Вирівнювання контенту')
	             ->set_conditional_logic( array(
		             'relation' => 'AND',
		             array(
			             'field' => 'block_option_add_form',
			             'value' => 'call-to-form',
			             'compare' => '=',
		             )
	             ) )
                  ->set_width(50)
                  ->add_options( array(
	                  'top-alignment' => 'По верху',
	                  'bottom-alignment' => 'По низу',
                  ) ),


			     ))
			     ->set_category( 'custom-category-home' )
			     ->set_icon('megaphone')

			     ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
				     ?>

				     <?php if( !empty( $fields['title'] ) && !empty( $fields['text'] ) ):?>

				         <section class="call-to-action <?php echo $fields['block_option_add_form'];?> animation-tracking"

						     <?php if( !empty( $fields['block_option_anchor_id'] ) ):?>
							     id="<?php echo $fields['block_option_anchor_id'];?>"
						     <?php endif;?>

						     <?php if( !empty( $fields['block_options_bg_color'] ) || !empty( $fields['block_options_text_color'] )):?>
							     style="<?php if ( !empty( $fields['block_options_bg_color'] ) ){echo 'background-color: '.$fields['block_options_bg_color'].';';} if ( !empty( $fields['block_options_text_color'] ) ){echo 'color: '.$fields['block_options_text_color'].';';}?>"
						     <?php endif;?>
						     >
					         <?php if( !empty($fields['bg_image']) ):?>
                     <div class="bg-img">
                       <img
                           class="lazy object-fit"
                           data-src="<?php echo wp_get_attachment_image_src($fields['bg_image'], 'full')[0];?>"
								         <?php
									         $altText = get_post_meta($fields['bg_image'], '_wp_attachment_image_alt', TRUE);
									         if ( !empty( $altText ) ):?>
                             alt="<?php echo $altText;?>"
									         <?php else:?>
                             alt="<?php echo wp_strip_all_tags($fields['title']);?>"
									         <?php endif;?>

                       >
                     </div>
					         <?php endif;?>
				           <div class="container">
				             <div class="row <?php if(!empty($fields['block_option_content_alignment'])){echo $fields['block_option_content_alignment'];}?>">
					             <div class="text-wrapper col-xxl-5 col-xl-6 col-lg-7 offset-xxl-1">
                         <?php if( !empty($fields['block_logo']) ):?>
                           <div class="pic-wrapper">
                             <img src="<?php echo $fields['block_logo'];?>" alt="<?php echo get_bloginfo('name');?>" class="svg-pic">
                           </div>
                         <?php endif;?>
						             <h2 class="block-title">
							             <?php echo str_replace(['<p>', '</p>'], '', $fields['title'] );?>
						             </h2>
						             <?php if( !empty($fields['text']) ):?>
							             <p class="call-text"><?php echo str_replace(['<p>', '</p>'], '', $fields['text'] );?></p>
						             <?php endif;?>
						             <?php if( $fields['block_option_add_form'] === 'call-to-single' ):?>
							             <div class="button small-btn <?php if ( !empty( $fields['block_option_btn_color'] ) ){echo $fields['block_option_btn_color'].'-btn';}else{echo 'basic-btn';}?>" data-bs-toggle="modal" data-bs-target="#formModal">
								             <?php echo $fields['btn_text'];?>
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                               <path d="M10.44 8.11065C10.44 7.83462 10.664 7.61088 10.94 7.61071L15.8897 7.61071L15.9906 7.62037C16.2184 7.66698 16.3897 7.86902 16.3897 8.11065V13.0604L16.38 13.1612C16.3333 13.389 16.1313 13.5603 15.8897 13.5603C15.6483 13.5602 15.4461 13.3889 15.3995 13.1612L15.3898 13.0604V9.31771L8.46511 16.2424C8.26983 16.4374 7.95319 16.4376 7.75801 16.2424C7.56292 16.0472 7.56301 15.7305 7.75801 15.5353L14.6827 8.6106L10.94 8.6106C10.664 8.61042 10.4401 8.38662 10.44 8.11065Z" fill="#F9FCF5"/>
                             </svg>
							             </div>
						             <?php endif;?>
					             </div>
					             <?php if( $fields['block_option_add_form'] === 'call-to-form' ):?>
                         <div class="form-wrapper col-xxl-4 offset-xl-1 offset-lg-0 col-lg-5 col-md-8 offset-md-2 col-sm-10 offset-sm-1">
                           <div class="inner">
	                           <?php



		                           $form_args = array(
			                           'btn_text' => $fields['btn_text'],
			                           'btn_color' => $fields['block_option_btn_color']
		                           );

		                           get_template_part('template-parts/form', null, $form_args);?>
                           </div>

                         </div>


					             <?php endif;?>

				             </div>
				           </div>
				         </section>
				     <?php endif;?>

				     <?php
			     } );
		}
