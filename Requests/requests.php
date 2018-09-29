<?php
$station_id = 1234; // Set to station ID
$api_key = 'abcd'; // Set to API key

/* Future Additions:
 - Popup modal when requesting to add name and comment
 - List how many requests user has left available in modal
*/

$server = 'https://api.shoutautomation.com';

if (isset($_GET['send']) && is_numeric($_GET['send'])) {
    // Make a request
    echo make_call($_GET['send']);
}
else {
    // List available tracks for requesting
    echo make_call(null);
}


function make_call($id = null) {
    global $station_id, $api_key, $server;

    $url = $server . '/requests?_sid=' . $station_id . '&_auth=' . $api_key . '&_t=' . time();

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    if ($id) {
        // Set POST variables when submitting a request
        $request = array(
            'content_id' => $id,
            'ip' => $_SERVER['REMOTE_ADDR'],
            'name' => '', /* Can be implemented in requests.html */
            'comment' => '', /* Can be implemented in requests.html */
            '_sid' => $station_id,
            '_auth' => $api_key
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($ch);

    curl_close($ch);


    return $output;
}
