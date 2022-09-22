<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://awesomecoder.dev/
 * @since      1.0.0
 *
 * @package    Leopards_tracker
 * @subpackage Leopards_tracker/admin/partials
 */

// $url = "http://leopards.com.pk/tracking1/index.php";

// $response = wp_remote_request(
//     $url,
//     array(
//         'method'      => 'POST',
//         'timeout'     => 45,
//         'redirection' => 5,
//         'httpversion' => '1.0',
//         'blocking'    => true,
//         'headers'     => array(),
//         'body'        => array(
//             "cn_number" => "551050188",
//         ),
//         'cookies'     => array()
//     )
// );

// if (is_wp_error($response)) {
//     $error_message = $response->get_error_message();
//     echo "Something went wrong: $error_message";
// } else {
//     $response =  wp_remote_retrieve_body($response);
//     echo "<pre>";
//     print_r($response);
//     echo "</pre>";
// }


$url = get_bloginfo("url") . "/wp-json/awesomecoder/tracking_api";
// $url = "http://localhost/wordpress/wp-json/awesomecoder/tracking_api";

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
            "trackid" => 551050188,
            // "trackid" => $track_id,
        ),
        'cookies'     => array()
    )
);

if (is_wp_error($response)) {
    $error_message = $response->get_error_message();
    echo "Something went wrong: $error_message";
} else {
    $response = json_decode(wp_remote_retrieve_body($response));
    // $response = wp_remote_retrieve_body($response);
    echo "<pre>";
    print_r($response);
    echo "</pre>";
}
