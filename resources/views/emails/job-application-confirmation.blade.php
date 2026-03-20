<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Received</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body style="font-family: 'Open Sans', sans-serif; background: #f9fafb; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
        
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #4f46e5, #7c3aed); padding: 40px 30px; text-align: center;">
            <h1 style="font-family: 'Urbanist', sans-serif; color: white; margin: 0; font-size: 28px;">Application Received!</h1>
            <p style="color: #e0e7ff; margin: 10px 0 0;">Thank you for applying</p>
        </div>

        <!-- Body -->
        <div style="padding: 40px 35px;">
            <h2 style="font-family: 'Urbanist', sans-serif; color: #1f2937; margin: 0 0 15px;">Hi {{ $applicant->firstname }},</h2>
            
            <p style="color: #6b7280; margin: 0 0 25px;">
                We've received your application for <strong style="color: #4f46e5;">{{ $job->title }}</strong> at <strong>{{ $job->company }}</strong>.
            </p>

            <!-- Job Details Card -->
            <div style="background: #f3f4f6; border-radius: 12px; padding: 25px; margin-bottom: 25px;">
                <h3 style="font-family: 'Urbanist', sans-serif; color: #1f2937; margin: 0 0 15px;">Application Summary</h3>
                
                <div style="border-bottom: 1px solid #e5e7eb; padding: 10px 0; display: flex; justify-content: space-between;">
                    <span style="color: #6b7280;">Position</span>
                    <span style="color: #1f2937; font-weight: 600;">{{ $job->title }}</span>
                </div>
                
                <div style="border-bottom: 1px solid #e5e7eb; padding: 10px 0; display: flex; justify-content: space-between;">
                    <span style="color: #6b7280;">Company</span>
                    <span style="color: #1f2937;">{{ $job->company }}</span>
                </div>
                
                <div style="border-bottom: 1px solid #e5e7eb; padding: 10px 0; display: flex; justify-content: space-between;">
                    <span style="color: #6b7280;">Location</span>
                    <span style="color: #1f2937;">{{ $job->location }}</span>
                </div>
                
                <div style="border-bottom: 1px solid #e5e7eb; padding: 10px 0; display: flex; justify-content: space-between;">
                    <span style="color: #6b7280;">Applied On</span>
                    <span style="color: #1f2937;">{{ $application->applied_at->format('F j, Y') }}</span>
                </div>
                
                <div style="padding: 10px 0; display: flex; justify-content: space-between;">
                    <span style="color: #6b7280;">Status</span>
                    <span style="background: #fef3c7; color: #92400e; padding: 2px 12px; border-radius: 9999px; font-size: 0.875rem;">Pending Review</span>
                </div>
            </div>

            <!-- Next Steps -->
            <div style="background: #eff6ff; border: 2px solid #dbeafe; border-radius: 12px; padding: 20px; margin-bottom: 25px;">
                <h4 style="font-family: 'Urbanist', sans-serif; color: #1e40af; margin: 0 0 10px;">What happens next?</h4>
                <ul style="color: #3b82f6; margin: 0; padding-left: 20px;">
                    <li style="margin-bottom: 8px;">The hiring team will review your application</li>
                    <li style="margin-bottom: 8px;">You'll be notified of any updates via email</li>
                    <li style="margin-bottom: 8px;">Track your application status in your dashboard</li>
                </ul>
            </div>

            <!-- Dashboard Button -->
            <div style="text-align: center;">
                <a href="{{ route('member.jobs.applications') }}" 
                   style="display: inline-block; background: #4f46e5; color: white; padding: 14px 30px; text-decoration: none; border-radius: 8px; font-family: 'Urbanist', sans-serif; font-weight: 600;">
                    Track Application
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div style="background: #f9fafb; border-top: 2px solid #e5e7eb; padding: 30px; text-align: center;">
            <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">
                © {{ date('Y') }} Africa Prosperity Network<br>
                This is an automated message, please do not reply.
            </p>
        </div>
    </div>
</body>
</html>