<?php
session_start(); //Retrieve the stored values
$env = $_SESSION['env'];
$redirectUrl = $_SESSION['redirectURL'];
$postdata = $_POST;
$key                =   $postdata['key'];
$salt                =   $postdata['salt'];
$txnid                 =     $postdata['txnid'];
$amount              =     $postdata['amount'];
$productInfo          =     $postdata['productinfo'];
$firstname            =     $postdata['firstname'];
$email                =    $postdata['email'];
$udf5                =   $postdata['udf5'];
$mihpayid            =    $postdata['mihpayid'];
$status                =     $postdata['status'];
$resphash                =     $postdata['hash'];
//Calculate response hash to verify	
$keyString               =      $key . '|' . $txnid . '|' . $amount . '|' . $productInfo . '|' . $firstname . '|' . $email . '|||||' . $udf5 . '|||||';
$keyArray               =     explode("|", $keyString);
$reverseKeyArray     =     array_reverse($keyArray);
$reverseKeyString    =    implode("|", $reverseKeyArray);
$CalcHashString     =     strtolower(hash('sha512', $salt . '|' . $status . '|' . $reverseKeyString));


if ($status == 'success'  && $resphash == $CalcHashString) {
    $paymentStatus = "SUCCESS";
} else {
    //tampered or failed
    $paymentStatus = "FAILURE";
}


if ($env === 'browser') {
    echo "<script>window.location.href='" . $redirectUrl . "?paymentStatus=" . $paymentStatus . "&orderId=" . $responsePayload['orderId'] . "&paymentProvider=payu'</script>"; //If it is a browser, you can directly redirect to your web app where you could handle it based on the transaction id stored in localstorage and the status sent in the query params. To ensure the status is not tampered with, expose an API to verify the status of the transaction using the transaction id.
} else {
    //Create two empty php files for success and failure status. But do not worry as when the browser is redirected to this url, our loadStart callback will be executed and this popup window will be closed in our application.
    if ($paymentStatus === 'SUCCESS') {
        echo "<script>window.location.href='<YOUR_BASE_URL>/SUCCESS_payu.php'</script>";
    }
    if ($paymentStatus === 'FAILURE') {
        echo "<script>window.location.href='<YOUR_BASE_URL>/FAILURE_payu.php'</script>";
    }
}
