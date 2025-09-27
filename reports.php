<?php
$DEFAULT_USER_ID = '609457498'; // default ProtonDB ID if none provided

// Set JSON response headers
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Get user ID from GET parameter or use default
$USER_ID = isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id'] : $DEFAULT_USER_ID;

// Validate user ID (should be numeric)
if (!is_numeric($USER_ID)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'Invalid user ID. Must be numeric.',
        'user_id' => $USER_ID
    ]);
    exit;
}

function getProtonDBData($userId) {
    $apiUrl = "https://www.protondb.com/data/users/by_id/{$userId}.json";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json, text/plain, */*',
        'Accept-Language: en-US,en;q=0.9',
        'Referer: https://www.protondb.com/',
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError) {
        return [
            'success' => false,
            'error' => 'cURL error: ' . $curlError
        ];
    }

    if ($httpCode !== 200) {
        return [
            'success' => false,
            'error' => "HTTP error: {$httpCode}"
        ];
    }

    if (!$response) {
        return [
            'success' => false,
            'error' => 'Empty response from ProtonDB API'
        ];
    }

    $data = json_decode($response, true);
    if (!$data) {
        return [
            'success' => false,
            'error' => 'Failed to parse JSON response'
        ];
    }

    if (!isset($data['reports']) || !is_array($data['reports'])) {
        return [
            'success' => false,
            'error' => 'Invalid response structure from ProtonDB API'
        ];
    }

    return [
        'success' => true,
        'user_id' => $userId,
        'reports_count' => count($data['reports']),
        'reports' => $data['reports'],
        'fetched_at' => date('Y-m-d H:i:s')
    ];
}

try {
    $result = getProtonDBData($USER_ID);

    if (!$result['success']) {
        http_response_code(500);
    }

    echo json_encode($result, JSON_PRETTY_PRINT);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Exception: ' . $e->getMessage(),
                     'user_id' => $USER_ID
    ], JSON_PRETTY_PRINT);
}
?>
