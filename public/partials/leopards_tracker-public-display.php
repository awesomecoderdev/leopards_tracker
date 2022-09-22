<div class="leopards_tracker">

    <?php

    if (isset($_REQUEST["track"])) :
        $track_id = $_REQUEST["track"];
        // $url = "http://localhost/wordpress/wp-json/awesomecoder/tracking_api";
        $url = get_bloginfo("url") . "/wp-json/awesomecoder/tracking_api";
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
                    "trackid" => $track_id,
                ),
                'cookies'     => array()
            )
        );
        // print_r($response);
        if (is_wp_error($response)) : ?>

            <table>
                <tr>
                    <th colspan="2">No data available</th>
                </tr>
            </table>

            <?php
        else :
            $response = json_decode(wp_remote_retrieve_body($response));
            if (!empty($response)) : ?>
                <table>
                    <tr>
                        <th colspan="2">Deliverey Details of <strong><?php echo $response->track; ?></strong> </th>
                    </tr>
                    <?php foreach ($response->delivery as $key => $data) : ?>
                        <tr>
                            <td><?php echo $data->delivery; ?></td>
                            <td><?php echo $data->data; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <table>
                    <tr>
                        <th colspan="2">Shipment Details</th>
                    </tr>
                    <tr>
                        <td>
                            <table>
                                <?php foreach ($response->origin as $key => $data) : ?>
                                    <tr>
                                        <td><?php echo $data->origin; ?></td>
                                        <td><?php echo $data->data; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </td>
                        <td>
                            <table>
                                <?php foreach ($response->refference as $key => $data) : ?>
                                    <tr>
                                        <td><?php echo $data->refference; ?></td>
                                        <td><?php echo $data->data; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th colspan="2">Date/Time</th>
                    </tr>
                    <?php foreach ($response->status as $key => $data) : ?>
                        <tr>
                            <td><?php echo $data->time; ?></td>
                            <td><?php echo $data->data; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else : ?>

                <table>
                    <tr>
                        <th colspan="2">No data available</th>
                    </tr>
                </table>
            <?php endif; ?>
        <?php endif; ?>
    <?php else : ?>
        <form method="get">
            <input type="text" name="track" id="track" placeholder="Tracking ID">
            <input type="submit" value="Track">
        </form>
    <?php endif; ?>
</div>