<?php
$payload = $_GET;

session_start();
$env = $_GET['env'];
$redirectUrl = $_GET['redirectURL'];
$params = $_GET; //rest of the query params required for payment
//The third party payment gateways will accept a redirect URL for which the gateway should redirect once the payment is completed along with the status of the transaction.
//Configure a common URL like '<YOUR_BASE_URL>/EndPayment.php'

if ($env === 'browser') {
    $_SESSION['env'] = $env;
    $_SESSION['redirectURL'] = $redirectUrl; //store the redirect url of the web app to redirect when the payment is completed
    send_to_payment_gateway('paytm'); //This implementation differs for each gateway, you can refer to their documentation for detailed implementation.
}
if ($env === 'app') {
    send_to_payment_gateway('paytm');
}


function send_to_payment_gateway($payment_provider)
{
    if ($payment_provider === 'paytm') {
        header('Location: ./paytmRedirect.php?' . $_SERVER['QUERY_STRING']);
    } else if ($payment_provider === 'payu') {
        header('Location: ./payuRedirect.php?' . $_SERVER['QUERY_STRING']);
    }
    //handle for other gateways
}
