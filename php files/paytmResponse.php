<?php
session_start(); //Retrieve the stored values
$env = $_SESSION['env'];
$redirectUrl = $_SESSION['redirectURL'];

//Verify the transaction status using the APIs provided by your payment gateway
$paymentStatus = 'SUCCESS'; //This should be set based on your transaction status
$responsePayload = $_POST;
if ($env === 'browser') {
    echo "<script>window.location.href='" . $redirectUrl . "?paymentStatus=" . $paymentStatus . "&orderId=" . $responsePayload['orderId'] . "&paymentProvider=paytm'</script>"; //If it is a browser, you can directly redirect to your web app where you could handle it based on the transaction id stored in localstorage and the status sent in the query params. To ensure the status is not tampered with, expose an API to verify the status of the transaction using the transaction id.
} else {
    //Create two empty php files for success and failure status. But do not worry as when the browser is redirected to this url, our loadStart callback will be executed and this popup window will be closed in our application.
    if ($paymentStatus === 'SUCCESS') {
        echo "<script>window.location.href='<YOUR_BASE_URL>/SUCCESS_paytm.php'</script>";
    }
    if ($paymentStatus === 'FAILURE') {
        echo "<script>window.location.href='<YOUR_BASE_URL>/FAILURE_paytm.php'</script>";
    }
}
