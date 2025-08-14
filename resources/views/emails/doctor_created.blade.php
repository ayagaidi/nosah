<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>بيانات الدخول للطبيب</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
            background-color: #f9f9f9;
            color: #333;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            border: 1px solid #ddd;
            padding: 20px;
            max-width: 600px;
            margin: auto;
            border-radius: 8px;
        }
        h2 {
            color: #007bff;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
        }
        .credentials {
            background-color: #f1f1f1;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
            font-size: 16px;
        }
        .footer {
            font-size: 14px;
            color: #777;
            margin-top: 30px;
            text-align: center;
        }
        a.button {
            display: inline-block;
            background-color: #007bff;
            color: #fff !important;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>مرحباً دكتور {{ $doctor->fullname }}</h2>
        <p>تم إنشاء حساب لك على نظامنا. يمكنك تسجيل الدخول باستخدام بيانات الدخول التالية:</p>
        <div class="credentials">
            <p><strong>رابط الدخول:</strong> <a href="{{ url('/') }}/doctor/login">{{ url('/') }}/doctor/login</a></p>
            <p><strong>البريد الإلكتروني:</strong> {{ $doctor->email }}</p>
            <p><strong>كلمة المرور:</strong> {{ $password }}</p>
        </div>
        <p>يرجى تغيير كلمة المرور بعد تسجيل الدخول للحفاظ على أمان حسابك.</p>
        <a href="{{ url('/') }}/doctor/login" class="button">تسجيل الدخول</a>
        <div class="footer">
            <p>شكراً لاستخدامك نظامنا.</p>
        </div>
    </div>
</body>
</html>
