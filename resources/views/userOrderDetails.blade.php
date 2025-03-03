<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .header {
            text-align: center;
            background-color: #4CAF50;
            color: white;
            padding: 10px 0;
            border-radius: 8px 8px 0 0;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h3 {
            margin-bottom: 10px;
            color: #333;
        }
        .section table {
            width: 100%;
            border-collapse: collapse;
        }
        .section table th, .section table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .section table th {
            background-color: #f2f2f2;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Order Confirmation</h1>
        </div>

        <div class="section">
            <h3>Order Summary</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($OrderDetails['products'] as $product)
                        <tr>
                            <td>{{ $product['product_name'] }}</td>
                            <td>{{ $product['quantity'] }}</td>
                            <td>{{ number_format($product['price'], 2) }}</td>
                            <td>{{ number_format($product['sub_total'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="section">
            <h3>Billing Details</h3>
            <p>
                <strong>Name:</strong> {{ $OrderDetails['billing']['firstName'] }} {{ $OrderDetails['billing']['lastName'] }}<br>
                <strong>Address:</strong> {{ $OrderDetails['billing']['address1'] }}, {{ $OrderDetails['billing']['city'] }}, {{ $OrderDetails['billing']['state'] }} - {{ $OrderDetails['billing']['postcode'] }}<br>
                <strong>Email:</strong> {{ $OrderDetails['billing']['email'] }}<br>
                <strong>Phone:</strong> {{ $OrderDetails['billing']['phone'] }}
            </p>
        </div>

        <div class="section">
            <h3>Shipping Details</h3>
            <p>
                <strong>Name:</strong> {{ $OrderDetails['shipping']['firstName'] }} {{ $OrderDetails['shipping']['lastName'] }}<br>
                <strong>Address:</strong> {{ $OrderDetails['shipping']['address1'] }}, {{ $OrderDetails['shipping']['city'] }}, {{ $OrderDetails['shipping']['state'] }} - {{ $OrderDetails['shipping']['postcode'] }}<br>
                <strong>Phone:</strong> {{ $OrderDetails['shipping']['phone'] }}
            </p>
        </div>

        <div class="section">
            <h3>Payment Summary</h3>
            <table>
                <tr>
                    <th>Total Amount</th>
                    <td>{{ number_format($OrderDetails['subTotal'], 2) }}</td>
                </tr>
                {{-- <tr>
                    <th>GST Amount</th>
                    <td>{{ number_format($OrderDetails['gstAmt'], 2) }}</td>
                </tr>
                <tr>
                    <th>Grand Total</th>
                    <td><strong>{{ number_format($OrderDetails['grand_Total'], 2) }}</strong></td>
                </tr> --}}
            </table>
        </div>

        <div class="footer">
            <p>Thank you for your order!</p>
        </div>
    </div>
</body>
</html> -->


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="en">
   <head>
      <meta charset="UTF-8">
      <meta content="width=device-width, initial-scale=1" name="viewport">
      <meta name="x-apple-disable-message-reformatting">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta content="telephone=no" name="format-detection">
      <title>Order Details</title>
    
      <style type="text/css">.rollover:hover .rollover-first { max-height:0px!important; display:none!important;}.rollover:hover .rollover-second { max-height:none!important; display:block!important;}.rollover span { font-size:0px;}u + .body img ~ div div { display:none;}#outlook a { padding:0;}span.MsoHyperlink,span.MsoHyperlinkFollowed { color:inherit; mso-style-priority:99;}a.n { mso-style-priority:100!important; text-decoration:none!important;}a[x-apple-data-detectors],#MessageViewBody a { color:inherit!important; text-decoration:none!important; font-size:inherit!important; font-family:inherit!important; font-weight:inherit!important; line-height:inherit!important;}.d { display:none; float:left; overflow:hidden; width:0; max-height:0; line-height:0; mso-hide:all;}@media only screen and (max-width:600px) {.be { padding-right:0px!important } .bd { padding-left:0px!important } .bc { padding-bottom:20px!important }
         *[class="gmail-fix"] { display:none!important } p, a { line-height:150%!important } h1, h1 a { line-height:120%!important } h2, h2 a { line-height:120%!important } h3, h3 a { line-height:120%!important } h4, h4 a { line-height:120%!important } h5, h5 a { line-height:120%!important } h6, h6 a { line-height:120%!important } .z p { } .y p { } .x p { } h1 { font-size:36px!important; text-align:left } h2 { font-size:26px!important; text-align:left } h3 { font-size:20px!important; text-align:left } h4 { font-size:24px!important; text-align:left } h5 { font-size:20px!important; text-align:left } h6 { font-size:16px!important; text-align:left } .ba h2 a, .z h2 a, .y h2 a { font-size:26px!important } .b td a { font-size:12px!important } .ba p, .ba a { font-size:14px!important } .z p, .z a { font-size:14px!important } .y p, .y a { font-size:14px!important } .x p, .x a { font-size:12px!important }
         .u, .u h1, .u h2, .u h3, .u h4, .u h5, .u h6 { text-align:center!important } .t, .t h1, .t h2, .t h3, .t h4, .t h5, .t h6 { text-align:right!important } .v, .v h1, .v h2, .v h3, .v h4, .v h5, .v h6 { text-align:left!important } .t .rollover:hover .rollover-second, .u .rollover:hover .rollover-second, .v .rollover:hover .rollover-second { display:inline!important } a.n, button.n { font-size:20px!important; padding:10px 20px 10px 20px!important; line-height:120%!important } a.n, button.n, .r { display:inline-block!important } .m, .m .n, .o, .o td, .b { display:inline-block!important } .j table, .k, .l { width:100%!important } .g table, .h table, .i table, .g, .i, .h { width:100%!important; max-width:600px!important } .adapt-img { width:100%!important; height:auto!important } .b td { width:1%!important } table.a, .esd-block-html table { width:auto!important } .h-auto { height:auto!important } }
         @media screen and (max-width:384px) {.mail-message-content { width:414px!important } }
      </style>
   </head>
   <body class="body" style="width:100%;height:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
      <div dir="ltr" class="es-wrapper-color" lang="en" style="background-color:transparent">
         <!--[if gte mso 9]>
         <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
            <v:fill type="tile" color="transparent" origin="0.5, 0" position="0.5, 0"></v:fill>
         </v:background>
         <![endif]-->
         <table width="100%" cellspacing="0" cellpadding="0" class="es-wrapper" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;background-color:transparent">
            <tr>
               <td valign="top" style="padding:0;Margin:0">
                  <table cellpadding="0" cellspacing="0" align="center" class="h" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important;background-color:transparent;background-repeat:repeat;background-position:center top">
                     <tr>
                        <td align="center" bgcolor="#000000" style="padding:0;Margin:0;background-color:#000000">
                           <table bgcolor="#ffffff" align="center" cellpadding="0" cellspacing="0" class="ba" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px">
                              <tr>
                                 <td align="left" style="padding:20px;Margin:0">
                                    <table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                       <tr>
                                          <td valign="top" align="center" class="be" style="padding:0;Margin:0;width:560px">
                                             <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                <tr>
                                                   <td align="center" style="padding:0;Margin:0;font-size:0px"><a target="_blank" href="https://launcherr.co/" style="mso-line-height-rule:exactly;text-decoration:underline;color:#666666;font-size:14px"><img src="https://flsivtr.stripocdn.email/content/guids/CABINET_75206220c4f76383f13e1cb69627caaa2ac8b37422217e464c70642f1f39e7f3/images/jpg_email_logo.jpg" alt="" width="200" title="Logo" class="adapt-img" style="display:block;font-size:12px;border:0;outline:none;text-decoration:none" height="60"></a> </td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>
                  <table cellpadding="0" cellspacing="0" align="center" class="g" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important">
                     <tr>
                        <td align="center" style="padding:0;Margin:0">
                           <table bgcolor="#ffffff" align="center" cellpadding="0" cellspacing="0" class="z" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
                              <tr>
                                 <td align="left" style="padding:0;Margin:0;padding-top:15px;padding-right:20px;padding-left:20px">
                                    <table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                       <tr>
                                          <td align="center" valign="top" style="padding:0;Margin:0;width:560px">
                                             <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                <tr>
                                                   <td align="center" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px;font-size:0px"><img src="https://flsivtr.stripocdn.email/content/guids/CABINET_54100624d621728c49155116bef5e07d/images/84141618400759579.png" alt="" width="100" style="display:block;font-size:14px;border:0;outline:none;text-decoration:none" height="98"></td>
                                                </tr>
                                                <tr>
                                                   <td align="center" style="padding:0;Margin:0;padding-bottom:10px">
                                                      <h1 class="u" style="Margin:0;font-family:arial, 'helvetica neue', helvetica, sans-serif;mso-line-height-rule:exactly;letter-spacing:0;font-size:46px;font-style:normal;font-weight:bold;line-height:46px;color:#333333">Order confirmation</h1>
                                                   </td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>
                  <table cellpadding="0" cellspacing="0" align="center" class="g" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important">
                     <tr>
                        <td align="center" style="padding:0;Margin:0">
                           <table bgcolor="#ffffff" align="center" cellpadding="0" cellspacing="0" class="z" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
                              <tr>
                                 <td align="left" style="padding:20px;Margin:0">
                                    <table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                       <tr>
                                          <td align="center" valign="top" style="padding:0;Margin:0;width:560px">
                                             <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                <tr>
                                                   <td align="center" style="padding:0;Margin:0">
                                                      <h2 class="u" style="Margin:0;font-family:arial, 'helvetica neue', helvetica, sans-serif;mso-line-height-rule:exactly;letter-spacing:0;font-size:26px;font-style:normal;font-weight:bold;line-height:31.2px;color:#333333">Order&nbsp;<a target="_blank" style="mso-line-height-rule:exactly;text-decoration:underline;color:#0b8aa1;font-size:26px" href="">{{$order_id}}</a></h2>
                                                   </td>
                                                </tr>
                                               
                                                <tr>
                                                   <td align="left" class="be bd" style="Margin:0;padding-top:5px;padding-right:40px;padding-left:40px;padding-bottom:15px">
                                                      <p style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px">Thank you for shopping with <strong>Launcherr!</strong> We’re thrilled to confirm your order and get your travel essentials ready for you.</p>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td align="center" style="padding:0;Margin:0"><span class="r" style="border-style:solid;border-color:#0b8aa1;background:#0b8aa1;border-width:2px;display:inline-block;border-radius:6px;width:auto"><a href="https://launcherr.co/dashboard/my_orders" target="_blank" class="n" style="mso-style-priority:100 !important;text-decoration:none !important;mso-line-height-rule:exactly;color:#FFFFFF;font-size:20px;padding:10px 30px 10px 30px;display:inline-block;background:#0b8aa1;border-radius:6px;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-weight:normal;font-style:normal;line-height:24px;width:auto;text-align:center;letter-spacing:0;mso-padding-alt:0;mso-border-alt:10px solid #0b8aa1;border-left-width:30px;border-right-width:30px">TRACK ORDER STATUS</a></span></td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                            @foreach ($OrderDetails['products'] as $product)
                              <tr>
                                 <td align="left" class="esdev-adapt-off" style="Margin:0;padding-right:20px;padding-left:20px;padding-top:10px;padding-bottom:10px">
                                    <table cellpadding="0" cellspacing="0" class="esdev-mso-table" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:560px">
                                       <tr>
                                          <td style="padding:0;Margin:0;width:20px"></td>
                                          <td valign="top" class="esdev-mso-td" style="padding:0;Margin:0">
                                             <table cellpadding="0" cellspacing="0" align="left" class="k" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                                                <tr>
                                                   <td align="center" style="padding:0;Margin:0;width:265px">
                                                      <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                         <tr>
                                                            <td align="left" style="padding:0;Margin:0">
                                                               <p style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px"><strong>{{ $product['product_name'] }}</strong></p>
                                                            </td>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </table>
                                          </td>
                                          <td style="padding:0;Margin:0;width:20px"></td>
                                          <td valign="top" class="esdev-mso-td" style="padding:0;Margin:0">
                                             <table cellpadding="0" cellspacing="0" align="left" class="k" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                                                <tr>
                                                   <td align="left" style="padding:0;Margin:0;width:80px">
                                                      <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                         <tr>
                                                            <td align="center" style="padding:0;Margin:0">
                                                               <p style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px">{{ $product['quantity'] }}</p>
                                                            </td>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </table>
                                          </td>
                                          <td style="padding:0;Margin:0;width:20px"></td>
                                          <td valign="top" class="esdev-mso-td" style="padding:0;Margin:0">
                                             <table cellpadding="0" cellspacing="0" align="right" class="l" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right">
                                                <tr>
                                                   <td align="left" style="padding:0;Margin:0;width:85px">
                                                      <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                         <tr>
                                                            <td align="right" style="padding:0;Margin:0">
                                                               <p style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px">{{ number_format($product['price'], 2) }}</p>
                                                            </td>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                            @endforeach
                              
                              <tr>
                                 <td align="left" style="padding:0;Margin:0;padding-right:20px;padding-left:20px;padding-top:10px">
                                    <table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                       <tr>
                                          <td align="center" class="be" style="padding:0;Margin:0;width:560px">
                                             <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;border-top:2px solid #efefef;border-bottom:2px solid #efefef" role="presentation">
                                                <tr>
                                                   <td align="right" style="padding:0;Margin:0;padding-top:10px;padding-bottom:20px">
                                                      <p class="t" style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px">Subtotal: <strong>{{ number_format($OrderDetails['subTotal'], 2) }}</strong></p>
                                                   </td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td align="left" style="Margin:0;padding-right:20px;padding-left:20px;padding-bottom:10px;padding-top:20px">
            
                                             <table cellpadding="0" cellspacing="0" align="left" class="k" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                                                <tr>
                                                   <td align="center" class="be bc" style="padding:0;Margin:0;width:280px">
                                                      <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                         <tr>
                                                            <td align="left" style="padding:0;Margin:0">
                                                               <p style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px">Customer: <strong>{{ $OrderDetails['billing']['firstName'] }} {{ $OrderDetails['billing']['lastName'] }}</strong></p>
                                                               <p style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px">Order number:&nbsp;<strong>{{$order_id}}</strong></p>
                                                               <!-- <p style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px">Invoice date:&nbsp;<strong>Apr 17, 2021</strong></p> -->
                                                               <!-- <p style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px">Payment method: <strong>CashFree</strong></p> -->
                                                               <p style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px">Currency: <strong>INR</strong></p>
                                                            </td>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </table>
                                             <!--[if mso]>
                                          </td>
                                          <td style="width:0px"></td>
                                          <td style="width:280px" valign="top">
                                             <![endif]-->
                                             <table cellpadding="0" cellspacing="0" align="right" class="l" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right">
                                                <tr>
                                                   <td align="center" class="be" style="padding:0;Margin:0;width:280px">
                                                      <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                         <tr>
                                                            <td align="left" style="padding:0;Margin:0">
                                                               <p class="v" style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px">Shipping Name: <strong> {{ $OrderDetails['shipping']['firstName'] }} {{ $OrderDetails['shipping']['lastName'] }}</strong></p>
                                                               <p class="v" style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px">Shipping address:</p>  
                                                               <p class="v" style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px"><strong>{{ $OrderDetails['shipping']['address1'] ?? $OrderDetails['shipping']['address2']}}</strong></p>
                                                               <p class="v" style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px"><strong>{{ $OrderDetails['shipping']['city'] }}, {{ $OrderDetails['shipping']['state'] }} - {{ $OrderDetails['shipping']['postcode'] }}</strong></p>
                                                               <p class="v" style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px"><strong>India</strong></p>
                                                            </td>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </table>
                                             <!--[if mso]>
                                          </td>
                                       </tr>
                                    </table>
                                    <![endif]-->
                                 </td>
                              </tr>
                              <tr>
                                 <td align="left" style="Margin:0;padding-top:15px;padding-right:20px;padding-left:20px;padding-bottom:10px">
                                    <table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                       <tr>
                                          <td align="left" style="padding:0;Margin:0;width:560px">
                                             <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                <tr>
                                                   <td align="center" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px">
                                                      <p style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px">Got a question?&nbsp;Email us at productsupport@launcherr.co</p>
                                                   </td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>
                  <table cellpadding="0" cellspacing="0" align="center" class="i" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important;background-color:transparent;background-repeat:repeat;background-position:center top">
                     <tr>
                        <td align="center" bgcolor="#000000" style="padding:0;Margin:0;background-color:#000000">
                           <table align="center" cellpadding="0" cellspacing="0" class="y" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:640px" role="none">
                              <tr>
                                 <td align="left" bgcolor="#000000" style="Margin:0;padding-right:20px;padding-left:20px;padding-bottom:20px;padding-top:20px;background-color:#000000">
                                    <table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                       <tr>
                                          <td align="left" style="padding:0;Margin:0;width:600px">
                                             <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                <tr>
                                                   <td align="center" style="padding:0;Margin:0;padding-top:15px;padding-bottom:15px;font-size:0">
                                                      <table cellpadding="0" cellspacing="0" class="a o" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                         <tr>
                                                            <td align="center" valign="top" style="padding:0;Margin:0;padding-right:40px"><img title="Facebook" src="https://flsivtr.stripocdn.email/content/assets/img/social-icons/logo-white/facebook-logo-white.png" alt="Fb" width="32" height="32" style="display:block;font-size:14px;border:0;outline:none;text-decoration:none"></td>
                                                            <td align="center" valign="top" style="padding:0;Margin:0;padding-right:40px"><img title="X" src="https://flsivtr.stripocdn.email/content/assets/img/social-icons/logo-white/x-logo-white.png" alt="X" width="32" height="32" style="display:block;font-size:14px;border:0;outline:none;text-decoration:none"></td>
                                                            <td align="center" valign="top" style="padding:0;Margin:0;padding-right:40px"><img title="Instagram" src="https://flsivtr.stripocdn.email/content/assets/img/social-icons/logo-white/instagram-logo-white.png" alt="Inst" width="32" height="32" style="display:block;font-size:14px;border:0;outline:none;text-decoration:none"></td>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td align="center" style="padding:0;Margin:0;padding-bottom:35px">
                                                      <p style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:18px;letter-spacing:0;color:#ffffff;font-size:12px">Sector 104, Noida, Uttar Pradesh - 201304, INDIA</p>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td style="padding:0;Margin:0">
                                                      <table cellpadding="0" cellspacing="0" width="100%" class="b" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                         <tr class="links">
                                                            <td align="center" valign="top" width="33.33%" style="Margin:0;border:0;padding-top:5px;padding-bottom:5px;padding-right:5px;padding-left:5px">
                                                               <div style="vertical-align:middle;display:block"><a target="_blank" href="https://launcherr.co/" style="mso-line-height-rule:exactly;text-decoration:none;font-family:arial, 'helvetica neue', helvetica, sans-serif;display:block;color:#999999;font-size:12px">Visit Us </a></div>
                                                            </td>
                                                            <td align="center" valign="top" width="33.33%" style="Margin:0;border:0;padding-top:5px;padding-bottom:5px;padding-right:5px;padding-left:5px;border-left:1px solid #cccccc">
                                                               <div style="vertical-align:middle;display:block"><a target="_blank" href="https://launcherr.co/PrivacyPolicy.html" style="mso-line-height-rule:exactly;text-decoration:none;font-family:arial, 'helvetica neue', helvetica, sans-serif;display:block;color:#999999;font-size:12px">Privacy Policy</a></div>
                                                            </td>
                                                            <td align="center" valign="top" width="33.33%" style="Margin:0;border:0;padding-top:5px;padding-bottom:5px;padding-right:5px;padding-left:5px;border-left:1px solid #cccccc">
                                                               <div style="vertical-align:middle;display:block"><a target="_blank" href="https://launcherr.co/TermsConditions.html" style="mso-line-height-rule:exactly;text-decoration:none;font-family:arial, 'helvetica neue', helvetica, sans-serif;display:block;color:#999999;font-size:12px">Terms of Use</a></div>
                                                            </td>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>
                  <table cellpadding="0" cellspacing="0" align="center" class="g" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important">
                     <tr>
                        <td align="center" class="es-info-area" style="padding:0;Margin:0">
                           <table align="center" cellpadding="0" cellspacing="0" bgcolor="#00000000" class="z" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" role="none">
                              <tr>
                                 <td align="left" style="padding:20px;Margin:0">
                                    <table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                       <tr>
                                          <td align="center" valign="top" style="padding:0;Margin:0;width:560px">
                                             <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                <tr>
                                                   <td align="center" class="x" style="padding:0;Margin:0">
                                                      <p style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:18px;letter-spacing:0;color:#CCCCCC;font-size:12px"><a target="_blank" href="" style="mso-line-height-rule:exactly;text-decoration:underline;color:#CCCCCC;font-size:12px"></a>No longer want to receive these emails?&nbsp;<a href="" target="_blank" style="mso-line-height-rule:exactly;text-decoration:underline;color:#CCCCCC;font-size:12px">Unsubscribe</a>.<a target="_blank" href="" style="mso-line-height-rule:exactly;text-decoration:underline;color:#CCCCCC;font-size:12px"></a></p>
                                                   </td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
         </table>
      </div>
   </body>
</html>