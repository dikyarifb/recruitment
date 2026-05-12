<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Applicant</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
<td align="center">
    <table width="600" cellpadding="0" cellspacing="0" 
        style="background-color: #ffffff; border-radius: 10px; overflow: hidden; font-family: Arial, Helvetica, sans-serif;">

        <!-- Header -->
        <tr>
            <td align="center" 
                style="background-color: #2c3e50; color: #ffffff; padding: 25px;">
                <h2 style="margin:0;">ARSA Indonesia</h2>
                <p style="margin:5px 0 0 0; font-size:14px;">
                    Recruitment Notification
                </p>
            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td style="padding: 30px; color:#333333;">

                <p style="margin-top:0;">
                    Dear HR Team,
                </p>

                <p>
                    A new job applicant has submitted an application through the recruitment system.
                </p>

                <!-- Applicant Information -->
                <table width="100%" cellpadding="10" cellspacing="0" 
                    style="border:1px solid #e5e5e5; border-collapse: collapse; margin-top:20px;">

                    <tr style="background-color:#f8f9fa;">
                        <td width="35%" 
                            style="border:1px solid #e5e5e5;">
                            <strong>Applicant Name</strong>
                        </td>
                        <td style="border:1px solid #e5e5e5;">
                            {{ $applicant->name }}
                        </td>
                    </tr>

                    <tr>
                        <td style="border:1px solid #e5e5e5;">
                            <strong>Position Applied</strong>
                        </td>
                        <td style="border:1px solid #e5e5e5;">
                            {{ $applicant->position }}
                        </td>
                    </tr>

                    <tr style="background-color:#f8f9fa;">
                        <td style="border:1px solid #e5e5e5;">
                            <strong>Gender</strong>
                        </td>
                        <td style="border:1px solid #e5e5e5;">
                            {{ $applicant->gender }}
                        </td>
                    </tr>

                    <tr style="background-color:#f8f9fa;">
                        <td style="border:1px solid #e5e5e5;">
                            <strong>Height</strong>
                        </td>
                        <td style="border:1px solid #e5e5e5;">
                            {{ $applicant->heigth }} cm
                        </td>
                    </tr>

                         <tr style="background-color:#f8f9fa;">
                        <td style="border:1px solid #e5e5e5;">
                            <strong>Weight</strong>
                        </td>
                        <td style="border:1px solid #e5e5e5;">
                            {{ $applicant->weight }} kg
                        </td>
                    </tr>

                    <tr>
                        <td style="border:1px solid #e5e5e5;">
                            <strong>Phone Number</strong>
                        </td>
                        <td style="border:1px solid #e5e5e5;">
                            {{ $applicant->phone }}
                        </td>
                    </tr>

                    <tr style="background-color:#f8f9fa;">
                        <td style="border:1px solid #e5e5e5;">
                            <strong>Email</strong>
                        </td>
                        <td style="border:1px solid #e5e5e5;">
                            {{ $applicant->email }}
                        </td>
                    </tr>

                    <tr>
                        <td style="border:1px solid #e5e5e5;">
                            <strong>Last Education</strong>
                        </td>
                        <td style="border:1px solid #e5e5e5;">
                            {{ $applicant->education }}
                        </td>
                    </tr>

                    <tr style="background-color:#f8f9fa;">
                        <td style="border:1px solid #e5e5e5;">
                            <strong>Work Experience</strong>
                        </td>
                        <td style="border:1px solid #e5e5e5;">
                            {{ $applicant->experience_position }} - {{ $applicant->experience_time }}
                        </td>
                    </tr>
                    <tr style="background-color:#f8f9fa;">
                        <td style="border:1px solid #e5e5e5;">
                            <strong>Introduction</strong>
                        </td>
                        <td style="border:1px solid #e5e5e5;">
                            {{ $applicant->introduction }}
                        </td>
                    </tr>
                     <tr style="background-color:#f8f9fa;">
                        <td style="border:1px solid #e5e5e5;">
                            <strong>CV</strong>
                        </td>
                        <td style="border:1px solid #e5e5e5;">
                            <a href="{{ \Storage::disk('s3')->url('recruitment/cv/'.$applicant->cv) }}">Download here</a>
                        </td>
                    </tr>
                    <tr style="background-color:#f8f9fa;">
                        <td style="border:1px solid #e5e5e5;">
                            <strong>Logic Score</strong>
                        </td>
                        <td style="border:1px solid #e5e5e5;">
                            {{ $applicant->iq_score }}
                        </td>
                    </tr>
                      <tr style="background-color:#f8f9fa;">
                        <td style="border:1px solid #e5e5e5;">
                            <strong>DiSC Score</strong>
                        </td>
                        <td style="border:1px solid #e5e5e5;">
                            {{ $applicant->disc_score }}
                            <p>
                                <small>{{ $applicant->disc_desc }}</small>
                            </p>
                        </td>
                    </tr>

                </table>

                <p style="margin-top:25px;">
                    Please review the applicant data and proceed with the recruitment process accordingly.
                </p>

                <p style="margin-bottom:0;">
                    Best regards,<br>
                    <strong>ARSA Indonesia</strong>
                </p>

            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td align="center" 
                style="font-size:12px; color:#999999; padding:20px; background-color:#f8f9fa;">
                This email was sent automatically. Please do not reply to this email.
            </td>
        </tr>

    </table>
</td>

        </tr>
    </table>

</body>
</html>