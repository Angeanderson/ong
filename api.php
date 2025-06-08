<?php
$apikey = "VOTRE_API_KEY";
$site_id = "VOTRE_SITE_ID";
$transaction_id = uniqid(); // ID unique
$amount = $_POST['amount']; // Montant envoyé depuis formulaire
$currency = "XOF";

$data = [
    "transaction_id" => $transaction_id,
    "amount" => $amount,
    "currency" => $currency,
    "description" => "Paiement sur mon site",
    "customer_name" => "Client",
    "customer_surname" => "Anonyme",
    "customer_email" => "client@test.com",
    "customer_phone_number" => "0505883696", // numéro Wave
    "customer_address" => "Abidjan",
    "customer_city" => "Abidjan",
    "customer_country" => "CI",
    "customer_state" => "CI",
    "customer_zip_code" => "00000",
    "notify_url" => "https://votre-site.com/notify.php",
    "return_url" => "https://votre-site.com/merci.php",
    "channels" => "ALL",
    "lang" => "fr"
];

// Init cURL
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.cinetpay.com/v1/payment",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "apikey: $apikey",
        "platform: site_id:$site_id"
    ]
]);

$response = curl_exec($curl);
curl_close($curl);
$result = json_decode($response, true);

if (isset($result['data']['payment_url'])) {
    header("Location: " . $result['data']['payment_url']);
    exit;
} else {
    echo "Erreur de création du paiement.";
    var_dump($result);
}
?>
