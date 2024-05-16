@extends('layouts.mail-suggestions')

@section('content')
    <tr>
        <td class="email-body" width="570" cellpadding="0" cellspacing="0" style="word-break: break-word; margin: 0; padding: 0; font-family: Nunito Sans,Helvetica,Arial,sans-serif; font-size: 16px; width: 100%; -premailer-width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0;">
            <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                <tr style="border-collapse:collapse">
                    <td class="es-info-area" align="center" bgcolor="#EA1F49" style="padding:0;Margin:0;background-color:#ea1f49">
                        <table bgcolor="transparent" class="es-content-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px">
                            <tr style="border-collapse:collapse">
                                <td align="left" style="Margin:0;padding-left:10px;padding-right:10px;padding-top:40px;padding-bottom:40px">
                                    <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                        <tr style="border-collapse:collapse">
                                            <td align="center" valign="top" style="padding:0;Margin:0;width:580px">
                                                <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                    <tr style="border-collapse:collapse">
                                                        <td align="center" class="es-infoblock" style="padding:0;Margin:0;line-height:19px;font-size:16px;color:#FFFFFF"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:28px;color:#FFFFFF;font-size:23px">Hi, {{$notifiable->name}}!</p></td>
                                                    </tr>
                                                    <tr style="border-collapse:collapse">
                                                        <td align="center" class="es-infoblock es-m-txt-c" style="padding:0;Margin:0;line-height:19px;font-size:16px;color:#FFFFFF"><h1 style="Margin:0;line-height:38px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:32px;font-style:normal;font-weight:bold;color:#ffffff">Buyers are ready to<br>meet with the best offers.</h1></td>
                                                    </tr>
                                                </table></td>
                                        </tr>
                                    </table></td>
                            </tr>
                        </table></td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                <tr style="border-collapse:collapse">
                    <td align="center" bgcolor="#ffffff" style="padding:0;Margin:0;background-color:#ffffff">
                        <table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#ffffff;width:600px">
                            @foreach($match->items as $item)
                                <tr style="border-collapse:collapse">
                                    <td align="left" style="Margin:0;padding-bottom:5px;padding-left:5px;padding-right:5px;padding-top:20px">
                                        <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                            <tr style="border-collapse:collapse">
                                                <td class="es-m-p20b" align="left" style="padding:0;Margin:0;width:590px">
                                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                        <tr style="border-collapse:collapse">
                                                            <td align="left" style="padding:0;Margin:0">
                                                                <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                    <tr style="border-collapse:collapse">
                                                                        <td align="left" style="padding:0;Margin:0"><h4 style="Margin:0;line-height:22px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:18px">{{$item->toObject()->product}}</h4></td>
                                                                    </tr>
                                                                    <tr style="border-collapse:collapse">
                                                                        <td align="left" style="padding:0;Margin:0"><p style="Margin:0;line-height:22px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:12px">{{$item->toObject()->person->business->name}}</p></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr style="border-collapse:collapse">
                                                            <td valign="top" align="center" style="padding:0;Margin:0;width:530px">
                                                                <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent" width="100%" cellspacing="0" cellpadding="0" bgcolor="transparent" role="presentation">
                                                                    <tbody><tr style="border-collapse:collapse">
                                                                        <td align="left" style="padding:0;Margin:0;padding-top:10px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:24px;color:#666666;font-size:16px">
                                                                                {{strlen($item->toObject()->description) > 200 ? substr($item->toObject()->description,0, 200)."..." : $item->toObject()->description}}
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr style="border-collapse:collapse">
                                    <td align="left" style="Margin:0;padding-bottom:5px;padding-left:5px;padding-right:5px;padding-top:10px">
                                        <!--[if mso]><table style="width:590px" cellpadding="0" cellspacing="0"><tr><td style="width:286px" valign="top"><![endif]-->
                                        <table cellpadding="0" cellspacing="0" class="es-left" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                                            <tr style="border-collapse:collapse">
                                                <td class="es-m-p20b" align="left" style="padding:0;Margin:0;width:286px">
                                                    <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                        <tr style="border-collapse:collapse">
                                                            <td align="left" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'Open Sans', sans-serif;line-height:21px;color:#262626;font-size:14px">Country: {{$item->toObject()->person->business->country->name}}</p></td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                        </table>
                                        <!--[if mso]></td><td style="width:20px"></td><td style="width:284px" valign="top"><![endif]-->
                                        <table cellpadding="0" cellspacing="0" class="es-right" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right">
                                            <tr style="border-collapse:collapse">
                                                <td align="left" style="padding:0;Margin:0;width:284px">
                                                    <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                        <tr style="border-collapse:collapse">
                                                            <td align="left" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'Open Sans', sans-serif;line-height:21px;color:#262626;font-size:14px">Category: {{$item->toObject()->category->name}}</p></td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                        </table>
                                        <!--[if mso]></td></tr></table><![endif]--></td>
                                </tr>
                                <tr style="border-collapse:collapse">
                                    <td align="left" bgcolor="#efefef" style="padding:0;Margin:0;padding-top:5px;padding-left:5px;padding-right:5px;background-color:#efefef">
                                        <!--[if mso]><table style="width:590px" cellpadding="0" cellspacing="0"><tr><td style="width:360px" valign="top"><![endif]-->
                                        <table cellpadding="0" cellspacing="0" class="es-left" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                                            <tr style="border-collapse:collapse">
                                                <td class="es-m-p0r es-m-p20b" valign="top" align="center" style="padding:0;Margin:0;width:360px">
                                                    <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                        <tr style="border-collapse:collapse">
                                                            <td align="left" style="padding:5px;Margin:0">
                                                                @if($item->toObject()->person->nextAvailable())
                                                                    <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'Open Sans', sans-serif;line-height:21px;color:#262626;font-size:14px">
                                                                        Available to meet on <strong>{{\Carbon\Carbon::parse($item->toObject()->person->nextAvailable())->format('d D M Y H:i A')}} UTC </strong>
                                                                    </p>
                                                                @else
                                                                    <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'Open Sans', sans-serif;line-height:21px;color:#262626;font-size:14px">
                                                                        <strong>No available time slots</strong>
                                                                    </p>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                        </table>
                                        <!--[if mso]></td><td style="width:40px"></td><td style="width:190px" valign="top"><![endif]-->
                                        <table cellpadding="0" cellspacing="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                            <tr style="border-collapse:collapse">
                                                <td align="left" style="padding:0;Margin:0;width:190px">
                                                    <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                        <tr style="border-collapse:collapse">
                                                            <td align="center" class="es-m-p10r es-m-p10l" style="padding:5px;Margin:0">
                                                                <!--[if mso]><a href="{{route('purchase_requirements.show.slug', $item->toObject()->slug)}}" target="_blank" hidden>
                                                                    <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" esdevVmlButton href=""
                                                                                 style="height:28px; v-text-anchor:middle; width:180px" arcsize="14%" stroke="f"  fillcolor="#1b2a2f">
                                                                        <w:anchorlock></w:anchorlock>
                                                                        <center style='color:#ffffff; font-family:arial, "helvetica neue", helvetica, sans-serif; font-size:8px; font-weight:700; line-height:8px;  mso-text-raise:1px'>Confirm and meet</center>
                                                                    </v:roundrect></a>
                                                                <![endif]-->
                                                                <!--[if !mso]><!-- -->
                                                                <span class="msohide es-button-border" style="border-style:solid;border-color:#cc0000;background:#1b2a2f;border-width:0px;display:block;border-radius:4px;width:auto;mso-hide:all">
                                                                <a href="{{route('purchase_requirements.show.slug', $item->toObject()->slug)}}" class="es-button es-button-1 msohide" target="_blank" style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#FFFFFF;font-size:14px;border-style:solid;border-color:#1B2A2F;border-width:5px;display:block;background:#1B2A2F;border-radius:4px;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-weight:bold;font-style:normal;line-height:17px;width:auto;text-align:center;mso-hide:all">Confirm and meet</a>
                                                            </span>
                                                                <!--<![endif]--></td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                        </table>
                                        <!--[if mso]></td></tr></table><![endif]--></td>
                                </tr>
                                <tr style="border-collapse:collapse">
                                    <td align="left" style="padding:0;Margin:0;background-position:center center">
                                        <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                            <tr style="border-collapse:collapse">
                                                <td align="center" valign="top" style="padding:0;Margin:0;width:600px">
                                                    <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                        <tr style="border-collapse:collapse">
                                                            <td align="center" style="padding:10px;Margin:0;font-size:0">
                                                                <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                    <tr style="border-collapse:collapse">
                                                                        <td style="padding:0;Margin:0;border-bottom:1px solid #cccccc;background:none;height:1px;width:100%;margin:0px"></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                        </table></td>
                                </tr>
                            @endforeach
                        </table>
                        <table cellpadding="0" cellspacing="0" class="es-footer" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:#111517;background-repeat:repeat;background-position:center top">
                            <tr style="border-collapse:collapse">
                                <td align="center" bgcolor="#999999" style="padding:0;Margin:0;background-color:#999999">
                                    <table class="es-footer-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#ffffff;width:600px" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                        <tr style="border-collapse:collapse">
                                            <td align="left" bgcolor="#999999" style="Margin:0;padding-bottom:5px;padding-left:20px;padding-right:20px;padding-top:40px;background-color:#999999">
                                                <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                    <tr style="border-collapse:collapse">
                                                        <td valign="top" align="center" style="padding:0;Margin:0;width:560px">
                                                            <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                <tr style="border-collapse:collapse">
                                                                    <td class="es-m-txt-l" align="left" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;color:#ffffff">Business is Better Face To Face</h4></td>
                                                                </tr>
                                                                <tr style="border-collapse:collapse">
                                                                    <td class="es-m-txt-l" align="left" style="padding:0;Margin:0"><h1 style="Margin:0;line-height:28px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:28px;font-style:normal;font-weight:bold;color:#ffffff">OnDemand business meetings<br>2.5 Million Businesses&nbsp;</h1></td>
                                                                </tr>
                                                                <tr style="border-collapse:collapse">
                                                                    <td class="es-m-txt-l" align="left" style="padding:0;Margin:0;padding-top:10px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:18px;color:#ffffff;font-size:12px">Meetings People, Made simple &amp; easy<br>Fully hosted B2B Online meetings</p></td>
                                                                </tr>
                                                                <tr style="border-collapse:collapse">
                                                                    <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-bottom:30px">
                                                                        <!--[if mso]><a href="https://searchmeetings.com/" target="_blank" hidden>
                                                                            <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" esdevVmlButton href="https://searchmeetings.com/"
                                                                                         style="height:51px; v-text-anchor:middle; width:206px" arcsize="10%" stroke="f"  fillcolor="#ea1f49">
                                                                                <w:anchorlock></w:anchorlock>
                                                                                <center style='color:#ffffff; font-family:roboto, "helvetica neue", helvetica, arial, sans-serif; font-size:16px; font-weight:700; line-height:16px;  mso-text-raise:1px'>Start Now</center>
                                                                            </v:roundrect></a>
                                                                        <![endif]-->
                                                                        <!--[if !mso]><!-- --><span class="msohide es-button-border-3 es-button-border" style="border-style:solid;border-color:#1B2A2F;background:#ea1f49;border-width:0px;display:inline-block;border-radius:5px;width:auto;mso-hide:all"><a href="https://searchmeetings.com/" class="es-button es-button-2" target="_blank" style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#FFFFFF;font-size:18px;border-style:solid;border-color:#ea1f49;border-width:15px 30px;display:inline-block;background:#ea1f49;border-radius:5px;font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif;font-weight:bold;font-style:normal;line-height:22px;width:auto;text-align:center">Start Now</a></span>
                                                                        <!--<![endif]--></td>
                                                                </tr>
                                                            </table></td>
                                                    </tr>
                                                </table></td>
                                        </tr>
                                    </table></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection