<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	require get_template_directory() . '/vendor/autoload.php';

	add_action('wp_ajax_form_integration', 'form_integration_callback');
	add_action('wp_ajax_nopriv_form_integration', 'form_integration_callback');

	function form_integration_callback(){

		if ( !isset($_POST['form_integration_nonce']) || !wp_verify_nonce( $_POST['form_integration_nonce'], 'form_integration' ) ) {
			wp_die();
		}

		function clearData($data) {
			return addslashes(strip_tags(trim($data)));
		}

		$integration_telegram_bot_api_key = carbon_get_theme_option('option_integration_telegram_api_key');
		$integration_telegram_chat_id = carbon_get_theme_option('option_integration_telegram_chat_id');
		$integration_email_list = carbon_get_theme_option('option_integration_email_list');
		$integration_key_crm_api_key = carbon_get_theme_option('option_integration_key_crm_api_key');
		$integration_key_crm_sours_id = carbon_get_theme_option('option_integration_key_crm_source_id');

		$siteName = get_bloginfo('name');

		$name = clearData($_POST['name']);
		$email = clearData($_POST['email']);
		$phone = clearData($_POST['phone']);
		$message = isset($_POST['message']) ? clearData($_POST['message']) : '';

		$pageName = clearData($_POST['page-name']);
		$pageUrl = clearData($_POST['page-url']);

		$utmSource = isset($_POST['utm_source']) ? clearData($_POST['utm_source']) : '';
		$utmMedium = isset($_POST['utm_medium']) ? clearData($_POST['utm_medium']) : '';
		$utmCampaign = isset($_POST['utm_campaign']) ? clearData($_POST['utm_campaign']) : '';
		$utmTerm = isset($_POST['utm_term']) ? clearData($_POST['utm_term']) : '';
		$utmContent = isset($_POST['utm_content']) ? clearData($_POST['utm_content']) : '';

		function kay_crm_integration($name, $email, $phone, $utmSource, $utmMedium, $utmCampaign, $utmTerm, $utmContent, $pageName, $pageUrl, $apiKey, $sourceId, $siteName, $message){

			$data = [
				"title" => "Заявка з сайту, сторінка $pageName",
				"source_id" => intval($sourceId),
				"manager_comment"=> $message,
				"manager_id" => 5,
				"contact" => [
					"full_name"=> $name,
					"email"=> $email,
					"phone"=> $phone
				],
				"utm_source" => $utmSource,
				"utm_medium" => $utmMedium,
				"utm_campaign" => $utmCampaign,
				"utm_term" => $utmTerm,
				"utm_content" => $utmContent,
				"products" => [
			    [
				    "name" => "Перелік послуг які цікавлять",
			    ]
			  ],
			];

			$data_string = json_encode($data);

			$token = $apiKey;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://openapi.keycrm.app/v1/pipelines/cards");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					"Content-type: application/json",
					"Accept: application/json",
					"Cache-Control: no-cache",
					"Pragma: no-cache",
					'Authorization:  Bearer ' . $token)
			);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result;

		}

		function mailIntegration($name, $email, $phone, $utmSource, $utmMedium, $utmCampaign, $utmTerm, $utmContent, $pageName, $pageUrl, $mailToList, $siteName){

			if (!empty($mailToList)){
				$send_email_list = '';
				foreach ($mailToList as $index=>$mail){
					if ( $index > 0 ){
						$send_email_list .= ', '.$mail['email'];
					}else{
						$send_email_list .= $mail['email'];
					}
				}
			}

			$to = $send_email_list;
			$headers = "Content-type: text/plain; charset = UTF-8";
			$subject = "Заявка з сайту $siteName з $pageName";
			$message = "Ім'я: $name \n Телефон: $phone \n Пошта: $email \n Адреса сторінки: $pageUrl\n\n UTM мітки: \n utmSource: $utmSource \n utmMedium: $utmMedium \n utmCampaign: $utmCampaign \n utmTerm: $utmTerm \n utmContent: $utmContent ";

			$send = mail ($to, $subject, $message, $headers);
		}

		if (!empty($integration_telegram_bot_api_key) && !empty($integration_telegram_chat_id)){

		}

		if (!empty($integration_key_crm_api_key) && !empty($integration_key_crm_sours_id)){
			kay_crm_integration($name, $email, $phone, $utmSource, $utmMedium, $utmCampaign, $utmTerm, $utmContent, $pageName, $pageUrl, $integration_key_crm_api_key, $integration_key_crm_sours_id, $siteName, $message);


		}

		if (!empty($integration_email_list)){

			$mailToList = $integration_email_list;

			mailIntegration($name, $email, $phone, $utmSource, $utmMedium, $utmCampaign, $utmTerm, $utmContent, $pageName, $pageUrl, $mailToList, $siteName);
		}







		wp_die();
	}