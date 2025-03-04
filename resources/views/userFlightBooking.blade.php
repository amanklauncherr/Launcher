<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Flight Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
            color: #555;
        }
        .details {
            margin-top: 20px;
        }
        .details table {
            width: 100%;
            border-collapse: collapse;
        }
        .details th, .details td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .details th {
            background-color: #f2f2f2;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Flight Booking Details</h1>
        <p>Dear User,</p>
        <p>Your flight booking has been successfully completed. Please find the details below:</p>
        
        <div class="details">
            <table>
                <tr>
                    <th>PNR</th>
                    <td>{{ $Pnr }}</td>
                </tr>
                <tr>
                    <th>Booking Reference</th>
                    <td>{{ $BookingRef }}</td>
                </tr>
                <tr>
                    <th>Download Ticket</th>
                    <td>
                        <a href="{{ $pdf_url }}" class="button" target="_blank">Download PDF</a>
                    </td>
                </tr>
            </table>
        </div>

        <p>If you have any questions or require further assistance, please contact us.</p>
        <p>Thank you for choosing our service!</p>
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
      <title>Flight Booking Confirmation</title>
      
      <style type="text/css">.rollover:hover .rollover-first { max-height:0px!important; display:none!important;}.rollover:hover .rollover-second { max-height:none!important; display:block!important;}.rollover span { font-size:0px;}u + .body img ~ div div { display:none;}#outlook a { padding:0;}span.MsoHyperlink,span.MsoHyperlinkFollowed { color:inherit; mso-style-priority:99;}a.es-button { mso-style-priority:100!important; text-decoration:none!important;}a[x-apple-data-detectors],#MessageViewBody a { color:inherit!important; text-decoration:none!important; font-size:inherit!important; font-family:inherit!important; font-weight:inherit!important; line-height:inherit!important;}.es-desk-hidden { display:none; float:left; overflow:hidden; width:0; max-height:0; line-height:0; mso-hide:all;}@media only screen and (max-width:600px) {.es-m-p5 { padding:5px!important } .es-m-p0r { padding-right:0px!important }
         .es-m-p0l { padding-left:0px!important } .es-m-p20b { padding-bottom:20px!important } .es-p-default { } *[class="gmail-fix"] { display:none!important } p, a { line-height:150%!important } h1, h1 a { line-height:120%!important } h2, h2 a { line-height:120%!important } h3, h3 a { line-height:120%!important } h4, h4 a { line-height:120%!important } h5, h5 a { line-height:120%!important } h6, h6 a { line-height:120%!important } .es-header-body p { } .es-content-body p { } .es-footer-body p { } .es-infoblock p { } h1 { font-size:36px!important; text-align:left } h2 { font-size:26px!important; text-align:left } h3 { font-size:20px!important; text-align:left } h4 { font-size:24px!important; text-align:left } h5 { font-size:20px!important; text-align:left } h6 { font-size:16px!important; text-align:left } .es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a { font-size:36px!important }
         .es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a { font-size:26px!important } .es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a { font-size:20px!important } .es-header-body h4 a, .es-content-body h4 a, .es-footer-body h4 a { font-size:24px!important } .es-header-body h5 a, .es-content-body h5 a, .es-footer-body h5 a { font-size:20px!important } .es-header-body h6 a, .es-content-body h6 a, .es-footer-body h6 a { font-size:16px!important } .es-menu td a { font-size:12px!important } .es-header-body p, .es-header-body a { font-size:14px!important } .es-content-body p, .es-content-body a { font-size:14px!important } .es-footer-body p, .es-footer-body a { font-size:14px!important } .es-infoblock p, .es-infoblock a { font-size:12px!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3, .es-m-txt-c h4, .es-m-txt-c h5, .es-m-txt-c h6 { text-align:center!important }
         .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3, .es-m-txt-r h4, .es-m-txt-r h5, .es-m-txt-r h6 { text-align:right!important } .es-m-txt-j, .es-m-txt-j h1, .es-m-txt-j h2, .es-m-txt-j h3, .es-m-txt-j h4, .es-m-txt-j h5, .es-m-txt-j h6 { text-align:justify!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3, .es-m-txt-l h4, .es-m-txt-l h5, .es-m-txt-l h6 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-m-txt-r .rollover:hover .rollover-second, .es-m-txt-c .rollover:hover .rollover-second, .es-m-txt-l .rollover:hover .rollover-second { display:inline!important } .es-m-txt-r .rollover span, .es-m-txt-c .rollover span, .es-m-txt-l .rollover span { line-height:0!important; font-size:0!important; display:block } .es-spacer { display:inline-table }
         a.es-button, button.es-button { font-size:20px!important; padding:10px 20px 10px 20px!important; line-height:120%!important } a.es-button, button.es-button, .es-button-border { display:inline-block!important } .es-m-fw, .es-m-fw.es-fw, .es-m-fw .es-button { display:block!important } .es-m-il, .es-m-il .es-button, .es-social, .es-social td, .es-menu { display:inline-block!important } .es-adaptive table, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .adapt-img { width:100%!important; height:auto!important } .es-mobile-hidden, .es-hidden { display:none!important } .es-desk-hidden { width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } tr.es-desk-hidden { display:table-row!important }
         table.es-desk-hidden { display:table!important } td.es-desk-menu-hidden { display:table-cell!important } .es-menu td { width:1%!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } .h-auto { height:auto!important } .img-3712 { width:198px!important; height:auto!important } }@media screen and (max-width:384px) {.mail-message-content { width:414px!important } }
      </style>
   </head>
   <body class="body" style="width:100%;height:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
      <div dir="ltr" class="es-wrapper-color" lang="en" style="background-color:#FAFAFA">
        
         <table width="100%" cellspacing="0" cellpadding="0" class="es-wrapper" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;background-color:#FAFAFA">
            <tr>
               <td valign="top" style="padding:0;Margin:0">
                  <table cellpadding="0" cellspacing="0" align="center" class="es-content" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important">
                     <tr>
                        <td align="center" class="es-info-area" style="padding:0;Margin:0">
                           <table align="center" cellpadding="0" cellspacing="0" bgcolor="#00000000" class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" role="none">
                              <tr>
                                 <td align="left" bgcolor="#000000" class="es-m-p5" style="padding:20px;Margin:0;background-color:#000000">
                                    <table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                       <tr>
                                          <td align="center" valign="top" style="padding:0;Margin:0;width:560px">
                                             <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                <tr>
                                                   <td align="center" class="es-infoblock" style="padding:0;Margin:0;font-size:0"><a target="_blank" href="https://launcherr.co/" style="mso-line-height-rule:exactly;text-decoration:underline;color:#CCCCCC;font-size:12px"><img src="https://etnyfjr.stripocdn.email/content/guids/CABINET_c827bce649f23e218d7e6a7bded9cd226e4e1ebb7eb92f396803d3dd8c10e600/images/image_pGk.jpeg" alt="" width="300" class="img-3712" height="70" style="display:block;font-size:14px;border:0;outline:none;text-decoration:none"></a> </td>
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
                  <table cellpadding="0" cellspacing="0" align="center" class="es-header" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important;background-color:transparent;background-repeat:repeat;background-position:center top">
                     <tr>
                        <td align="center" style="padding:0;Margin:0">
                           <table bgcolor="#ffffff" align="center" cellpadding="0" cellspacing="0" class="es-header-body" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px">
                              <tr>
                                 <td align="left" bgcolor="#000000" style="padding:20px;Margin:0;background-color:#000000">
                                    <table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                       <tr>
                                          <td align="center" valign="top" class="es-m-p0r" style="padding:0;Margin:0;width:560px">
                                             <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                <tr>
                                                   <td style="padding:0;Margin:0">
                                                      <table cellpadding="0" cellspacing="0" width="100%" class="es-menu" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                         <tr class="links">
                                                            <td align="center" valign="top" width="25.00%" style="Margin:0;border:0;padding-top:5px;padding-right:5px;padding-bottom:5px;padding-left:5px">
                                                               <div style="vertical-align:middle;display:block"><a href="https://launcherr.co/flights/" target="_blank" style="mso-line-height-rule:exactly;text-decoration:none;font-family:arial, 'helvetica neue', helvetica, sans-serif;display:block;color:#fefdfd;font-size:14px">Flights</a> </div>
                                                            </td>
                                                            <td align="center" valign="top" width="25.00%" style="Margin:0;border:0;padding-top:5px;padding-right:5px;padding-bottom:5px;padding-left:5px;border-left:1px dotted #000000">
                                                               <div style="vertical-align:middle;display:block"><a href="https://launcherr.co/bus" target="_blank" style="mso-line-height-rule:exactly;text-decoration:none;font-family:arial, 'helvetica neue', helvetica, sans-serif;display:block;color:#fefdfd;font-size:14px">Buses</a></div>
                                                            </td>
                                                            <td width="25.00%" align="center" valign="top" style="Margin:0;border:0;padding-top:5px;padding-right:5px;padding-bottom:5px;padding-left:5px;border-left:1px dotted #000000">
                                                               <div style="vertical-align:middle;display:block"><a target="_blank" href="https://launcherr.co/products" style="mso-line-height-rule:exactly;text-decoration:none;font-family:arial, 'helvetica neue', helvetica, sans-serif;display:block;color:#fefdfd;font-size:14px">Shop</a></div>
                                                            </td>
                                                            <td valign="top" width="25.00%" align="center" style="Margin:0;border:0;padding-top:5px;padding-right:5px;padding-bottom:5px;padding-left:5px;border-left:1px dotted #000000">
                                                               <div style="vertical-align:middle;display:block"><a target="_blank" href="https://launcherr.co/about" style="mso-line-height-rule:exactly;text-decoration:none;font-family:arial, 'helvetica neue', helvetica, sans-serif;display:block;color:#fefdfd;font-size:14px">About</a></div>
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
                  <table cellpadding="0" cellspacing="0" align="center" class="es-content" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important">
                     <tr>
                        <td align="center" style="padding:0;Margin:0">
                           <table bgcolor="#ffffff" align="center" cellpadding="0" cellspacing="0" class="es-content-body" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
                              <tr>
                                 <td align="left" style="padding:0;Margin:0;padding-top:15px;padding-right:20px;padding-left:20px">
                                    <table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                       <tr>
                                          <td align="center" valign="top" style="padding:0;Margin:0;width:560px">
                                             <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                <tr>
                                                   <td align="center" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px;font-size:0px"><img src="https://etnyfjr.stripocdn.email/content/guids/CABINET_c827bce649f23e218d7e6a7bded9cd226e4e1ebb7eb92f396803d3dd8c10e600/images/image_uz0.jpeg" alt="" width="560" class="adapt-img" style="display:block;font-size:14px;border:0;outline:none;text-decoration:none" height="315"></td>
                                                </tr>
                                                <tr>
                                                   <td align="center" style="padding:0;Margin:0;padding-bottom:10px">
                                                      <h1 class="es-m-txt-c" style="Margin:0;font-family:arial, 'helvetica neue', helvetica, sans-serif;mso-line-height-rule:exactly;letter-spacing:0;font-size:46px;font-style:normal;font-weight:bold;line-height:46px;color:#333333">Flight Booked!</h1>
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
                  <table cellpadding="0" cellspacing="0" align="center" class="es-content" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important">
                     <tr>
                        <td align="center" style="padding:0;Margin:0">
                           <table bgcolor="#ffffff" align="center" cellpadding="0" cellspacing="0" class="es-content-body" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
                              <tr>
                                 <td align="left" style="padding:20px;Margin:0">
                                    <table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                       <tr>
                                          <td align="center" valign="top" style="padding:0;Margin:0;width:560px">
                                             <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                <tr>
                                                   <td align="center" class="es-m-p0r es-m-p0l" style="Margin:0;padding-top:5px;padding-right:40px;padding-bottom:15px;padding-left:40px">
                                                      <p style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px"><strong>Okay Okay Okay!!! We just got the confirmation that you've booked your flight successfully! Just relax and wait for your next adventure. We hope you have a great and safe flight.</strong></p>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td align="center" style="padding:0;Margin:0"><span class="es-button-border" style="border-style:solid;border-color:#5c68e2;background:#5c68e2;border-width:2px;display:inline-block;border-radius:6px;width:auto"><a href="{{ $pdf_url }}" target="_blank" class="es-button" style="mso-style-priority:100 !important;text-decoration:none !important;mso-line-height-rule:exactly;color:#FFFFFF;font-size:20px;padding:10px 30px 10px 30px;display:inline-block;background:#5C68E2;border-radius:6px;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-weight:normal;font-style:normal;line-height:24px;width:auto;text-align:center;letter-spacing:0;mso-padding-alt:0;mso-border-alt:10px solid #5C68E2;border-left-width:30px;border-right-width:30px">GET YOUR TICKET!</a></span></td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td align="left" class="esdev-adapt-off" style="Margin:0;padding-top:10px;padding-bottom:10px;padding-right:20px;padding-left:20px">
                                    <table cellpadding="0" cellspacing="0" class="esdev-mso-table" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:560px">
                                       <tr>
                                         
                                          <td style="padding:0;Margin:0;width:20px"></td>
                                          <td valign="top" class="esdev-mso-td" style="padding:0;Margin:0">
                                             <table cellpadding="0" cellspacing="0" align="left" class="es-left" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                                                <tr>
                                                   <td align="center" style="padding:0;Margin:0;width:265px">
                                                      <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                         <tr>
                                                            <td align="left" style="padding:0;Margin:0">
                                                               <p style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px"><strong>PNR </strong></p>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td align="left" style="padding:0;Margin:0;padding-top:5px">
                                                               <p style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px">{{ $Pnr }}</p>
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
                              <tr>
                                 <td align="left" style="padding:0;Margin:0;padding-top:10px;padding-right:20px;padding-left:20px">
                                    <table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                       <tr>
                                          <td align="center" class="es-m-p0r" style="padding:0;Margin:0;width:560px">
                                             <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;border-top:2px solid #efefef;border-bottom:2px solid #efefef" role="presentation">
                                                <tr>
                                                   <td align="right" style="padding:0;Margin:0;padding-top:10px;padding-bottom:20px">
                                                      <p class="es-m-txt-r" style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px">Subtotal: <strong>{{$BaseFare}}</strong><br>Tax: <strong>{{$Tax}}</strong><br>Total: <strong>{{$TotalAmount}}</strong></p>
                                                   </td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td align="left" style="Margin:0;padding-bottom:10px;padding-right:20px;padding-left:20px;padding-top:20px">
                                    <table cellpadding="0" cellspacing="0" align="left" class="es-left" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                                       <tr>
                                          <td align="center" class="es-m-p0r es-m-p20b" style="padding:0;Margin:0;width:560px">
                                             <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                <tr>
                                                   <td align="left" style="padding:0;Margin:0">
                                                      <p style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px">Customer: <strong>{{$user_mail}}</strong></p>
                                                      <p style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px">Order number:&nbsp;<strong>{{$BookingRef}}</strong></p>
                                                   </td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td align="left" style="Margin:0;padding-bottom:10px;padding-top:15px;padding-right:20px;padding-left:20px">
                                    <table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                       <tr>
                                          <td align="left" style="padding:0;Margin:0;width:560px">
                                             <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                <tr>
                                                   <td align="center" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px">
                                                      <p style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px">Got a question?&nbsp;Email us at Flightsupport@launcherr.co&nbsp;</p>
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
                  <table cellpadding="0" cellspacing="0" align="center" class="es-footer" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important;background-color:transparent;background-repeat:repeat;background-position:center top">
                     <tr>
                        <td align="center" style="padding:0;Margin:0">
                           <table align="center" cellpadding="0" cellspacing="0" class="es-footer-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:640px" role="none">
                              <tr>
                                 <td align="left" bgcolor="#000000" style="Margin:0;padding-right:20px;padding-left:20px;padding-bottom:20px;padding-top:20px;background-color:#000000">
                                    <table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                       <tr>
                                          <td align="left" style="padding:0;Margin:0;width:600px">
                                             <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                <tr>
                                                   <td align="center" style="padding:0;Margin:0;padding-top:15px;padding-bottom:15px;font-size:0">
                                                      <table cellpadding="0" cellspacing="0" class="es-table-not-adapt es-social" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                         <tr>
                                                            <td align="center" valign="top" style="padding:0;Margin:0;padding-right:40px"><a target="_blank" href="https://m.facebook.com/61561668118192" style="mso-line-height-rule:exactly;text-decoration:underline;color:#333333;font-size:12px"><img title="Facebook" src="https://etnyfjr.stripocdn.email/content/assets/img/social-icons/logo-white/facebook-logo-white.png" alt="Fb" width="32" height="32" style="display:block;font-size:14px;border:0;outline:none;text-decoration:none"></a> </td>
                                                            <td align="center" valign="top" style="padding:0;Margin:0;padding-right:40px"><a target="_blank" href="https://www.instagram.com/launcherr.co/" style="mso-line-height-rule:exactly;text-decoration:underline;color:#333333;font-size:12px"><img title="Instagram" src="https://etnyfjr.stripocdn.email/content/assets/img/social-icons/logo-white/instagram-logo-white.png" alt="Inst" width="32" height="32" style="display:block;font-size:14px;border:0;outline:none;text-decoration:none"></a></td>
                                                            <td align="center" valign="top" style="padding:0;Margin:0"><a target="_blank" href="https://x.com/Launcherr_co" style="mso-line-height-rule:exactly;text-decoration:underline;color:#333333;font-size:12px"><img title="X" src="https://etnyfjr.stripocdn.email/content/assets/img/social-icons/logo-white/x-logo-white.png" alt="X" width="32" height="32" style="display:block;font-size:14px;border:0;outline:none;text-decoration:none"></a></td>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td align="center" style="padding:0;Margin:0;padding-bottom:35px">
                                                      <p style="Margin:0;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:18px;letter-spacing:0;color:#333333;font-size:12px"><span style="color:#ffffff">Sector 104 - Noida, Uttar Pradesh - 201304, India</span></p>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td style="padding:0;Margin:0">
                                                      <table cellpadding="0" cellspacing="0" width="100%" class="es-menu" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                         <tr class="links">
                                                            <td align="center" valign="top" width="33.33%" style="Margin:0;border:0;padding-top:5px;padding-right:5px;padding-bottom:5px;padding-left:5px">
                                                               <div style="vertical-align:middle;display:block"><a target="_blank" href="https://launcherr.co/" style="mso-line-height-rule:exactly;text-decoration:none;font-family:arial, 'helvetica neue', helvetica, sans-serif;display:block;color:#ffffff;font-size:12px">Visit Us </a></div>
                                                            </td>
                                                            <td align="center" valign="top" width="33.33%" style="Margin:0;border:0;padding-top:5px;padding-right:5px;padding-bottom:5px;padding-left:5px;border-left:1px solid #cccccc">
                                                               <div style="vertical-align:middle;display:block"><a target="_blank" href="https://launcherr.co/PrivacyPolicy.html" style="mso-line-height-rule:exactly;text-decoration:none;font-family:arial, 'helvetica neue', helvetica, sans-serif;display:block;color:#ffffff;font-size:12px">Privacy Policy</a></div>
                                                            </td>
                                                            <td align="center" valign="top" width="33.33%" style="Margin:0;border:0;padding-top:5px;padding-right:5px;padding-bottom:5px;padding-left:5px;border-left:1px solid #cccccc">
                                                               <div style="vertical-align:middle;display:block"><a target="_blank" href="https://launcherr.co/TermsConditions.html" style="mso-line-height-rule:exactly;text-decoration:none;font-family:arial, 'helvetica neue', helvetica, sans-serif;display:block;color:#ffffff;font-size:12px">Terms of Use</a></div>
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
                  <table cellpadding="0" cellspacing="0" align="center" class="es-content" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important">
                     <tr>
                        <td align="center" class="es-info-area" style="padding:0;Margin:0">
                           <table align="center" cellpadding="0" cellspacing="0" bgcolor="#00000000" class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" role="none">
                              <tr>
                                 <td align="left" style="padding:20px;Margin:0">
                                    <table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                       <tr>
                                          <td align="center" valign="top" style="padding:0;Margin:0;width:560px">
                                             <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                <tr>
                                                   <td align="center" class="es-infoblock" style="padding:0;Margin:0">
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