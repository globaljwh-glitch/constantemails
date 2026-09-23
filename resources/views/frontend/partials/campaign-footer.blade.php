<table width="100%" cellpadding="0" cellspacing="0" border="0"
       style="margin-top:30px; border-top:1px solid #dddddd;">
    <tr>
        <td align="center"
            style="padding:20px 10px; font-family:Arial, sans-serif; font-size:12px; line-height:20px; color:#777777;">

            @if(!empty($footer))
                <div style="margin-bottom:10px;">
                    {!! $footer !!}
                </div>
            @endif

            <div>
                You are receiving this email because you subscribed to our mailing list.
            </div>

            <div style="margin-top:8px;">
                If you no longer wish to receive these emails,
                <a href="{{ $unsubscribeUrl }}"
                   style="color:#e53935; text-decoration:underline;">
                    Unsubscribe
                </a>
            </div>

            <div style="margin-top:10px;">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </div>

        </td>
    </tr>
</table>