<?php
$data = $_GET;
$data['redirectUrl'] = 'YOUR_CALLBACK_URL/payuResponse.php';
$data['mid'] = 'YOUR_MID';
$salt = 'YOUR_SALT';
$hash = hash('sha512', $data['key'] . '|' . $data['orderId'] . '|' . $data['transactionAmount'] . '|' . '' . '|' . $data['firstname'] . '|' . $data['email'] . '|||||||||||' . $salt);
$json['success'] = $hash;
?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PayUmoney</title>


    <!-- this meta viewport is required for BOLT //-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">


</head>
<style type="text/css">

</style>

<body>
    <div class="main">
        <center>
            <h1>Please do not refresh this page...</h1>
        </center>
        <form action="#" name="payu_form">
            <input type="hidden" id="furl" name="furl" value="<?php echo $data['redirectUrl']; ?>" />
            <input type="hidden" id="surl" name="surl" value="<?php echo $data['redirectUrl']; ?>" />
            <div class="dv">
                <span><input type="hidden" id="key" name="key" placeholder="Merchant Key" value="<?php echo $data['mid']; ?>" /></span>
            </div>

            <div class="dv">
                <span><input type="hidden" id="salt" name="salt" placeholder="Merchant Salt" value="<?php echo $salt; ?>" /></span>
            </div>

            <div class="dv">
                <span><input type="hidden" id="txnid" name="txnid" placeholder="Transaction ID" value="<?php echo  $data['orderId']; ?>" /></span>
            </div>

            <div class="dv">
                <span><input type="hidden" id="amount" name="amount" placeholder="Amount" value="<?php echo  $data['transactionAmount']; ?>" /></span>
            </div>

            <div class="dv">
                <span><input type="hidden" id="pinfo" name="pinfo" placeholder="Product Info" value="" /></span>
            </div>

            <div class="dv">
                <span><input type="hidden" id="fname" name="fname" placeholder="First Name" value="<?php echo  $data['firstname']; ?>" /></span>
            </div>

            <div class="dv">
                <span><input type="hidden" id="email" name="email" placeholder="Email ID" value="<?php echo  $data['email']; ?>" /></span>
            </div>

            <div class="dv">
                <span><input type="hidden" id="mobile" name="mobile" placeholder="Mobile/Cell Number" value="<?php echo  $data['phone']; ?>" /></span>
            </div>

            <div class="dv">
                <span><input type="hidden" id="hash" name="hash" placeholder="Hash" value="<?php echo  $hash; ?>" /></span>
            </div>

        </form>
    </div>
    <script type="text/javascript">
        document.payu_form.submit();
    </script>

</body>

</html>