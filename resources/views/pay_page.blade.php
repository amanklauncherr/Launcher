<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pay Now</title>
    <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
</head>
<body onload="payment()">
    <input type="hidden" id="paymentSessionId" value="{{ $payment_session_id }}">

    <script type="text/javascript">
        function payment(){
            // var cashfree = Cashfree({ mode: 'sandbox' });
            var cashfree = Cashfree({ mode: 'sandbox' });
            let checkoutOptions = {
                paymentSessionId: document.getElementById("paymentSessionId").value,
                redirectTarget: "_self"
            };
            cashfree.checkout(checkoutOptions);
        }
    </script>
</body>
</html>
