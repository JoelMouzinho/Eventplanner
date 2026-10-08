<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../services/EventService.php';

requireAdmin($pdo);

$error = '';
$saved = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
        $error = 'Die Anfrage ist abgelaufen. Bitte versuche es erneut.';
    } else {
        $definition = pricingCatalogDefinition();
        $submittedPrices = $_POST['price'] ?? [];

        foreach ($definition as $category => $categoryData) {
            foreach ($categoryData['items'] as $itemKey => $itemLabel) {
                $raw = $submittedPrices[$category][$itemKey] ?? '0';
                $price = (float) str_replace(',', '.', (string) $raw);

                if ($price < 0) {
                    $price = 0.0;
                }

                setPricingPrice($pdo, $category, $itemKey, $price);
            }
        }

        $saved = true;
    }
}

$definition = pricingCatalogDefinition();
$prices = getPricingCatalog($pdo);
