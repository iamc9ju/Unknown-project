<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - ระบบจัดการโครงการจำนำข้าว</title>

    <!-- เพิ่ม Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&family=Sarabun:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Global CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Prompt', sans-serif;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background-color: #f8f9fa;
        }

        .container {
            display: flex;
            height: 100vh;
            /* เต็มหน้าจอ */
            width: 100%;
        }

        .side-bar {
            flex: 0 0 13%;
            /* ความกว้าง 20% */
            background-color: #ffffff;
            /* สีเทาเข้มดูเรียบหรู */
            color: #ecf0f1;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .content {
            flex: 1;
            /* ที่เหลือ 80% */
            background-color: #f5f5f5;
            padding: 30px;
            box-sizing: border-box;
            overflow-y: auto;
            /* ถ้าเนื้อหาเยอะให้เลื่อน */
            border-left: 1px solid #ddd;
            /* เส้นแบ่งฝั่ง */
        }

        .side-bar a {
            display: block;
            color: #ecf0f1;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 8px;
            margin: 5px 0;
            transition: background 0.3s, padding-left 0.3s;
            font-size: 36px;
        }

        .side-bar a:hover {
            background-color: #34495e;
            padding-left: 25px;
        }
        

        /* Right Sidebar */
        .right-sidebar {
            flex: 0 0 20%;
            /* ตัวอย่าง 10–15% */
            background-color: #ddf2d1;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            border-left:2px solid #ddd;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                /* ซ้อนกันแทน */
            }

            .side-bar {
                flex: 0 0 auto;
                width: 100%;
            }

            .content {
                width: 100%;
                border-left: none;
                border-top: 1px solid #ddd;
            }

            .side-bar {
        background-color: #ffffff;
        border-right: 1px solid #ddd;
        color: #2c3e50;
    
    </style>
    @yield('styles')
</head>

<body>
    <div class="container">
        <div class="side-bar">
            <div class="logo">
                <h2 style="color: #2c3e50; font-weight: 300; margin-bottom: 20px;">จัดการเกษตรกร</h2>
            </div>
        
            <nav class="menu">
                <a href="{{ url('/farmer/dashboard') }}" class="menu-item">
                    🏠 หน้าแรก
                </a>
                /* <a href="{{ url('/projects') }}" class="menu-item">
                    📋 จัดการโครงการ
                </a>
                <a href="{{ url('/farmers') }}" class="menu-item">
                    👨‍🌾 จัดการเกษตรกร
                </a>
                <a href="{{ url('/rice') }}" class="menu-item">
                    🌾 ข้อมูลข้าว
                </a>
                <a href="{{ url('/pledge') }}" class="menu-item">
                    💰 การจำนำข้าว
                </a>
                <a href="{{ url('/reports') }}" class="menu-item">
                    📊 รายงานสรุป
                </a> */
            </nav>
            @yield('side-bar')
        </div>
        <div class='content'>
            @yield('content')
        </div>
        <div class="right-sidebar">
            @yield('right-sidebar')
        </div>
    </div>


</body>

</html>
