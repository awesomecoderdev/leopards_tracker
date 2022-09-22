<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://awesomecoder.dev/
 * @since      1.0.0
 *
 * @package    Ac_leopards_tracker_downloader
 * @subpackage Ac_leopards_tracker_downloader/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Ac_leopards_tracker_downloader
 * @subpackage Ac_leopards_tracker_downloader/includes
 * @author     Md. Ibrahim Kholil <awesomecoder.dev@gmail.com>

 *
 *                                                            _
 *                                                           | |
 *  __ ___      _____  ___  ___  _ __ ___   ___  ___ ___   __| | ___ _ __
 * / _` \ \ /\ / / _ \/ __|/ _ \| '_ ` _ \ / _ \/ __/ _ \ / _` |/ _ \ '__|
 *| (_| |\ V  V /  __/\__ \ (_) | | | | | |  __/ (_| (_) | (_| |  __/ |
 * \__,_| \_/\_/ \___||___/\___/|_| |_| |_|\___|\___\___/ \__,_|\___|_|
 *
 */

/**
 * The class responsible for defining all actions that occur in the api area.
 */

require_once plugin_dir_path(dirname(__FILE__)) . "includes/class-leopards_tracker-ai.php";



function awesomecoder_leopards_tracker_api($request)
{

	$trackid = $request["trackid"];

	$url = "http://leopards.com.pk/tracking1/index.php";

	$response = wp_remote_request(
		$url,
		array(
			'method'      => 'POST',
			'timeout'     => 45,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking'    => true,
			'headers'     => array(),
			'body'        => array(
				"cn_number" => "$trackid",
			),
			'cookies'     => array()
		)
	);

	if (is_wp_error($response)) {
		$error_message = $response->get_error_message();
		echo "Something went wrong: $error_message";
	} else {
		$response =  wp_remote_retrieve_body($response);
		echo $response;
	}
}


add_action('rest_api_init', function () {
	register_rest_route('awesomecoder/', 'leopards_tracker/', array(
		'methods' => 'GET',
		'callback' => 'awesomecoder_leopards_tracker_api',
	));
});




function leopards_tracking_api($request)
{
	$trackid = trim($request["trackid"]);

	$output = array();
	// 551050188
	$url = get_bloginfo("url") . "/wp-json/awesomecoder/leopards_tracker/?trackid=$trackid";
	// $url = "http://localhost/wordpress/wp-json/awesomecoder/leopards_tracker/?trackid=$trackid";
	$html = leopards_tracker($url);
	$html = $html->find('table', 0);
	$html = $html->find('tr', 0);

	$status = $html->find('table', 7);
	$refference = $html->find('table', 6);
	$origin = $html->find('table', 5);
	$delivery = $html->find('table', 2);

	// track
	$html->find('table', 0);
	$track = $html->find('tr', 0)->plaintext;
	$track = str_replace("Consignment No. :", "", $track);
	$track = str_replace(" ", "", $track);


	$output["track"] = str_replace("&nbsp;", "", trim(strip_tags(trim(preg_replace('/\s\s+/', ' ', $track)))));

	// status
	$i = 1;
	foreach ($status->find('tr') as $data) {
		$time = $data->find('td', 0)->plaintext;
		$val = $data->find('td', 1)->plaintext;
		if ($i > 2) {
			$output["status"][] = array(
				"time" => str_replace("&nbsp;", "", strip_tags(trim(preg_replace('/\s\s+/', ' ', $time)))),
				"data" => str_replace("&nbsp;", "", strip_tags(trim(preg_replace('/\s\s+/', ' ', $val)))),
			);
		}
		$i++;
	}

	// origin
	foreach ($origin->find('tr') as $data) {
		$origin = $data->find('td', 0)->plaintext;
		$origin = str_replace(":", "", $origin);

		$val = $data->find('td', 1)->plaintext;
		$output["origin"][] = array(
			"origin"	=> str_replace("&nbsp;", "", strip_tags(trim(preg_replace('/\s\s+/', ' ', $origin)))),
			"data" 		=> str_replace("&nbsp;", "", strip_tags(trim(preg_replace('/\s\s+/', ' ', $val)))),
		);
	}

	// refference
	foreach ($refference->find('tr') as $data) {
		$refference = $data->find('td', 0)->plaintext;
		$refference = str_replace(":", "", $refference);

		$val = $data->find('td', 1)->plaintext;
		$output["refference"][] = array(
			"refference" => str_replace("&nbsp;", "", strip_tags(trim(preg_replace('/\s\s+/', ' ', $refference)))),
			"data"		 => str_replace("&nbsp;", "", strip_tags(trim(preg_replace('/\s\s+/', ' ', $val)))),
		);
	}

	// delivery
	$i = 1;
	foreach ($delivery->find('tr') as $data) {
		$delivery = $data->find('td', 0)->plaintext;
		$delivery = str_replace(":", "", $delivery);
		$val = $data->find('td', 1)->plaintext;
		if ($i > 1) {
			$output["delivery"][] = array(
				"delivery" 	=> str_replace("&nbsp;", "", strip_tags(trim(preg_replace('/\s\s+/', ' ', $delivery)))),
				"data" 		=> str_replace("&nbsp;", "", strip_tags(trim(preg_replace('/\s\s+/', ' ', $val)))),
			);
		}
		$i++;
	}

	return $output;
}


add_action('rest_api_init', function () {
	register_rest_route('awesomecoder/', 'tracking_api/', array(
		'methods' => 'POST',
		'callback' => 'leopards_tracking_api',
	));
});
