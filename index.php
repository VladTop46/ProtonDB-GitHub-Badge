<?php
$DEFAULT_USER_ID = '609457498'; // default ProtonDB ID if none provided
$BADGE_COLOR = 'red'; // change this to your preferred color (example red, green, blue)

// Get user ID from GET parameter or use default
$USER_ID = isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id'] : $DEFAULT_USER_ID;

// Validate user ID (should be numeric)
if (!is_numeric($USER_ID)) {
    $badgeUrl = "https://img.shields.io/badge/ProtonDB%20reports-invalid%20ID-red?logo=steam";
    header("Location: {$badgeUrl}");
    exit;
}

function getReportsCountFromAPI($userId) {
    $reportsApiUrl = "https://{$_SERVER['HTTP_HOST']}" . dirname($_SERVER['REQUEST_URI']) . "/reports.php?id={$userId}";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $reportsApiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200 || !$response) {
        return false;
    }

    $data = json_decode($response, true);
    if (!$data || !$data['success']) {
        return false;
    }

    return $data['reports_count'];
}

function generateBadgeUrl($count, $color) {
    return "https://img.shields.io/badge/ProtonDB%20reports-{$count}-{$color}?logo=steam";
}

try {
    $reportsCount = getReportsCountFromAPI($USER_ID);

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