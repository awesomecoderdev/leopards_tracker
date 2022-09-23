<div class="leopards_tracker">

    <?php

    if (isset($_REQUEST["track"])) : $track_id = $_REQUEST["track"]; ?>
        <div id="awesomecoder">
            <table>
                <tr>
                    <th colspan="2">Processing...</th>
                </tr>
            </table>
        </div>

        <script>
            jQuery(document).ready(function() {
                jQuery.ajax({
                    type: "GET",
                    url: "<?php echo $url = admin_url("admin-ajax.php?action=leopards_tracker_ajax_request&trackid=$track_id"); ?>",
                    success: function(response) {
                        jQuery("#awesomecoder").html(response);
                    }
                });
            });
        </script>
    <?php else : ?>
        <form method="get">
            <input type="text" name="track" id="track" placeholder="Tracking ID">
            <input type="submit" value="Track">
        </form>
    <?php endif; ?>
</div>