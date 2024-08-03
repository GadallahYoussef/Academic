<?php
// API URL
$url = 'https://smsmisr.com/api/SMS/';

// API Parameters
$params = array(
    'environment' => '2',
    'username' => '71fac7b7-aa1a-46a3-91f5-34660fea61a4',
    'password' => '4f0f083153ed3ae1e56f98e0b62ae96581b5c5d68bb25cc5bdd5ec76e2aefab8',
    'language' => '1',
    'sender' => 'b611afb996655a94c8e942a823f1421de42bf8335d24ba1f84c437b2ab11ca27',
    'mobile' => '201061953831',
    'message' => 'Hola'
);

// Initialize cURL
$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

// Execute the request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
} else {
    // Print the response from the API
    echo 'Response: ' . $response;
}

// Close cURL resource
curl_close($ch);
