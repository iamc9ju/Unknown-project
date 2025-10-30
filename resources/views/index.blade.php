@extends('layouts.app')

@section('title', 'หน้าแรก')

@section('styles')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background: #f9fafb;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(rgba(22, 163, 74, 0.6), rgba(21, 128, 61, 0.5)),
                url('{{ asset('images/rice-field-hero.jpg') }}') center/cover no-repeat;
            color: white;
            padding: 100px 20px;
            text-align: center;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(to right, #facc15, #f97316);
            /* ทอง → ส้ม */
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 1s ease;
        }


        .hero-section h1 {
            font-size: 4rem;
            font-weight: bold;
            color: #ffffff;
            /* ขาว */
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
            /* เงาดำเบา ๆ */
            margin-bottom: 0.5rem;
        }

        .hero-section .subtitle {
            font-size: 1.5rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
            color: #f3f4f6;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
            /* เงาดำเบา ๆ */
            animation: fadeInUp 1.2s ease;
        }

        .hero-section .country {
            font-size: 1.2rem;
            opacity: 0.9;
            color: #f3f4f6;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }

        /* Cards Section */
        .cards-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
        }

        .section-title {
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 0.5rem;
            color: #1f2937;
        }

        .section-description {
            text-align: center;
            color: #6b7280;
            margin-bottom: 2rem;
            font-size: 1rem;
        }

        .cards-grid {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: 1fr;
        }

        @media (min-width: 768px) {
            .cards-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .cards-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        /* Card Style */
        .card {
            text-decoration: none;
            display: block;
        }

        .card-inner {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover .card-inner {
            transform: translateY(-6px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .card:hover .card-header img {
            transform: scale(1.05);
        }

        .card-header {
            height: 180px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f9fafb;
        }

        .card-header img {
            width: 100%;
            height: auto;
            /* ปล่อยความสูงตามสัดส่วนจริง */
            object-fit: scale-down;
            /* ถ้าภาพใหญ่กว่ากรอบจะย่อ แต่ไม่บิดเบี้ยว */
            transition: transform 0.4s ease;
        }


        .card-body {
            padding: 1.5rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            height: 200px;
            /* width: auto; */
            /* กำหนดความสูงขั้นต่ำให้พอดีกับ 3-4 บรรทัด */
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 0.25rem;
            color: #1f2937;
        }

        .card-subtitle {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .card-description {
            font-size: 0.95rem;
            color: #4b5563;
            /* margin-top: auto; ดันข้อความให้อยู่ล่างลงไป */
        }
    </style>
@endsection

@section('content')
    <div>
        <!-- Hero Section -->
        <div class="hero-section">
            <h1>🌾 ระบบจัดการโครงการจำนำข้าว</h1>
            <p class="subtitle">Rice Pledging Management System</p>
            <p class="country">รัฐบาลประเทศสารขัณฑ์</p>
        </div>

        <!-- Cards Section -->
        <div class="cards-container">
            <h2 class="section-title">เลือกส่วนงาน</h2>
            <p class="section-description">เลือกส่วนงานที่ต้องการจัดการ</p>

            <div class="cards-grid">
                <!-- Farmer Card -->
                <a href="{{ route('farmer.profile.index') }}" class="card">
                    <div class="card-inner">
                        <div class="card-header">
                            <img src="{{ asset('images/farmer-icon.jpg') }}" alt="Farmer">
                        </div>
                        <div class="card-body">
                            <h3 class="card-title">เกษตรกร</h3>
                            <p class="card-subtitle">Farmers</p>
                            <p class="card-description">จัดการข้อมูลเกษตรกรและสิทธิ์การจำนำ</p>
                        </div>
                    </div>
                </a>

                <!-- Mill Card -->
                <a href="#" class="card">
                    <div class="card-inner">
                        <div class="card-header">
                            <img src="{{ asset('images/mill-icon.jpg') }}" alt="Mill">
                        </div>
                        <div class="card-body">
                            <h3 class="card-title">โรงสี</h3>
                            <p class="card-subtitle">Mills</p>
                            <p class="card-description">จัดการข้อมูลโรงสีและคลังเก็บข้าว</p>
                        </div>
                    </div>
                </a>

                <!-- Receipt Card -->
                <a href="#" class="card">
                    <div class="card-inner">
                        <div class="card-header">
                            <img src="{{ asset('images/receipt-icon.jpg') }}" alt="Receipt">
                        </div>
                        <div class="card-body">
                            <h3 class="card-title">ใบประทวน</h3>
                            <p class="card-subtitle">Pledge Receipts</p>
                            <p class="card-description">บันทึกการรับจำนำและการไถ่ถอนข้าว</p>
                        </div>
                    </div>
                </a>

                <!-- G2G Card -->
                <a href="#" class="card">
                    <div class="card-inner">
                        <div class="card-header">
                            <img src="{{ asset('images/government-icon.jpg') }}" alt="Government">
                        </div>
                        <div class="card-body">
                            <h3 class="card-title">G2G</h3>
                            <p class="card-subtitle">Government Sales</p>
                            <p class="card-description">จัดการสัญญาขายข้าวรัฐต่อรัฐ </p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
