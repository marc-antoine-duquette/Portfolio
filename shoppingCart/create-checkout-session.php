<?php

require_once 'stripe/init.php';
require_once 'secrets.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$items = $data["items"];
$line_items = [];

$json_items = json_decode(file_get_contents("items.json"), true);
foreach ($items as $item){
    foreach ($json_items as $json_item){
        if ($item["id"] == $json_item["id"]){
            $line_items[] = [
				'price' => $json_item["priceId"],
				'quantity' => $item["qte"],
			];
            break;
        }
    }
}

try {
    $stripe = new \Stripe\StripeClient($stripeSecretKey);
	
	$checkout_session = $stripe->checkout->sessions->create([
        'locale' => 'fr-CA',
		'line_items' => $line_items,
		'mode' => 'payment',
		'ui_mode' => 'embedded',
        "redirect_on_completion" => 'never',
	]);

    $output = [
        'clientSecret' => $checkout_session->client_secret,
    ];

    echo json_encode($output);
} catch (\Stripe\Exception\ApiErrorException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}