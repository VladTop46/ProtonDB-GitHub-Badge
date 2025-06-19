<?php
$DEFAULT_USER_ID = '609457498'; # default ProtonDB ID if none provided
$BADGE_COLOR = 'red'; # change this to your preferred color (example red, green, blue)

// get user ID from GET parameter or use default
$USER_ID = isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id'] : $DEFAULT_USER_ID;

// validate user ID (should be numeric)
if (!is_numeric($USER_ID)) {
    $badgeUrl = "https://img.shields.io/badge/ProtonDB%20reports-invalid%20ID-red?logo=steam";
    header("Location: {$badgeUrl}");
    exit;
}

function getReportsCount($userId) {
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
    curl_close($ch);

    if ($httpCode !== 200 || !$response) {
        return false;
    }

    $data = json_decode($response, true);
    if (!$data || !isset($data['reports']) || !is_array($data['reports'])) {
        return false;
    }

    return count($data['reports']);
}

function generateBadgeUrl($count, $color) {
    return "https://img.shields.io/badge/ProtonDB%20reports-{$count}-{$color}?logo=steam";
}

try {
    $reportsCount = getReportsCount($USER_ID);

    if ($reportsCount === false) {
        $badgeUrl = "https://img.shields.io/badge/ProtonDB%20reports-error-lightgrey?logo=steam";
    } else {
        $badgeUrl = generateBadgeUrl($reportsCount, $BADGE_COLOR);
    }

    header("Location: {$badgeUrl}");
    exit;

} catch (Exception $e) {
    $badgeUrl = "https://img.shields.io/badge/ProtonDB%20reports-error-lightgrey?logo=steam";
    header("Location: {$badgeUrl}");
    exit;
}
?>