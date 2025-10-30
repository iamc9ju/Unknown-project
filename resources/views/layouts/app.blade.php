{{-- หน้าหลักลิงค์ไปส่วนต่างๆ --}}
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - ระบบจัดการโครงการจำนำข้าว</title>
    
    <!-- เพิ่ม Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Global CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Prompt', sans-serif;
        }
        
        body {
            font-family: 'Sarabun', 'Prompt', sans-serif;
            line-height: 1.6;
        }
    </style>
    @yield('styles')
</head>
<body>
    @yield('content')
</body>
</html>