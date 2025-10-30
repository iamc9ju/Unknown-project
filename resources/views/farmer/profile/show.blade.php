{{-- ดูรายละเอียด --}}
@extends('layouts.farmer.dashboard')
@section('styles')
    <style>
        /* Responsive Icon Sizes */
        .icon-container {
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* Tablet and up */
        @media (min-width: 768px) {
            .icon-container {
                width: 80px;
                height: 80px;
            }
        }

        /* Desktop and up */
        @media (min-width: 1024px) {
            .icon-container {
                width: 96px;
                height: 96px;
            }
        }

        /* Extra large screens */
        @media (min-width: 1400px) {
            .icon-container {
                width: 100px;
                height: 100px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid p-4 " style="background-color: #dce9fc">
        <div class="row">
            <!-- Left Section -->
            <div class="col-lg-8 rounded-4">
                <!-- Stats Cards -->

                <div class="row g-3 g-md-4 mb-4">
                    <!-- Card 1: พื้นที่ทั้งหมด -->
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100 rounded-4">
                            <div class="card-body p-3 p-md-4">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="mt-2 mt-md-3">
                                        <h3 class="fw-normal mb-0 fs-4 fs-md-3">{{$farmer->total_rai}}</h3>
                                        <small class="text-muted">พื้นที่ทั้งหมด</small>
                                    </div>
                                    <div class="bg-info bg-opacity-10 rounded-circle flex-shrink-0 icon-container">
                                        <img src="{{ asset('images/park-garden.png') }}" 
                                             alt="Park & Garden icon" 
                                             class="icon-img">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Card 2: ข้าวที่จำนำแล้ว -->
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100 rounded-4">
                            <div class="card-body p-3 p-md-4">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="mt-2 mt-md-3">
                                        <h3 class="fw-normal mb-0 fs-4 fs-md-3">{{$farmer->pledged_amount_kg}}</h3>
                                        <small class="text-muted">ข้าวที่จำนำแล้ว</small>
                                    </div>
                                    <div class="bg-success bg-opacity-10 rounded-circle flex-shrink-0 icon-container">
                                        <img src="{{ asset('images/rice_logo.png') }}" 
                                             alt="Rice icon" 
                                             class="icon-img">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Card 3: สิทธิ์คงเหลือ -->
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100 rounded-4">
                            <div class="card-body p-3 p-md-4">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="mt-2 mt-md-3">
                                        <h3 class="fw-normal mb-0 fs-4 fs-md-3">{{$farmer->pledge_right_kg-$farmer->pledged_amount_kg}}</h3>
                                        <small class="text-muted">สิทธิ์คงเหลือ</small>
                                    </div>
                                    <div class="bg-warning bg-opacity-10 rounded-circle flex-shrink-0 icon-container">
                                        <img src="{{ asset('images/rights_logo.png') }}" 
                                             alt="Rights icon" 
                                             class="icon-img">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Card 4: มูลค่ารวม (Optional) -->
                    {{-- <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card border-0 shadow-sm h-100 rounded-4">
                            <div class="card-body p-3 p-md-4">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="mt-2 mt-md-3">
                                        <h3 class="fw-normal mb-0 fs-4 fs-md-3">18k+</h3>
                                        <small class="text-muted">มูลค่ารวม</small>
                                    </div>
                                    <div class="bg-danger bg-opacity-10 rounded-circle flex-shrink-0 icon-container">
                                        <img src="{{ asset('images/total_income_logo.png') }}" 
                                             alt="Total income icon" 
                                             class="icon-img">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>

                <!-- ข้อมูลเกษตรกร -->
                <div class="card border-0 shadow-sm mb-4 rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-semibold mb-0">ข้อมูลเกษตรกร</h5>
                            <span class="badge bg-success px-3 py-2">ใช้งานอยู่</span>
                        </div>

                        <div class="row g-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle p-2 me-3">
                                        <i class="bi bi-person text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">ชื่อเกษตรกร</div>
                                        <div class="text-dark">{{ $farmer->first_name }} {{ $farmer->last_name }}</div>
                                        <small class="text-muted">รหัสเกษตรกร : {{ $farmer->farmer_id }}</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle p-2 me-3">
                                        <i class="bi bi-geo-alt text-success"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">ที่อยู่</div>
                                        <div class="text-dark">{{ $farmer->address }}  {{$farmer->village_name}} {{$farmer->subdistricts->name_in_thai}}  {{$farmer->districts->name_in_thai}}
                                            {{$farmer->provinces->name_in_thai}} {{$farmer->subdistricts->zip_code}}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle p-2 me-3">
                                        <i class="bi bi-telephone text-info"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">เบอร์โทรศัพท์</div>
                                        <div class="text-dark">{{$farmer->phone_number}}</div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle p-2 me-3">
                                        <i class="bi bi-envelope text-danger"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semobold">อีเมล</div>
                                        <div class="text-dark">somchai@farmer.com</div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>

                <!-- ประวัติการจำนำ -->
                <div class="mb-4 p-4 rounded-4" style="background-color: aliceblue">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-medium mb-0">ประวัติการจำนำ</h5>
                        <a href="#" class="text-primary text-decoration-none">See All</a>
                    </div>

                    <div class="row g-3">
                        <!-- Card 1 -->
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100 rounded-4">
                                <div class="card-body text-center">
                                    <div class="bg-light rounded-4 p-4 mb-3">
                                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 150'%3E%3Crect fill='%23E8F4F8' width='200' height='150'/%3E%3C/svg%3E"
                                            alt="Development" class="img-fluid" style="max-height: 120px;">
                                    </div>
                                    <span class="badge bg-success bg-opacity-10 text-success mb-2">Development</span>
                                    <h6 class="fw-bold mb-0">การพัฒนาระบบ</h6>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100 rounded-4">
                                <div class="card-body text-center">
                                    <div class="bg-light rounded-4 p-4 mb-3">
                                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 150'%3E%3Crect fill='%23FFF4E6' width='200' height='150'/%3E%3C/svg%3E"
                                            alt="Design" class="img-fluid" style="max-height: 120px;">
                                    </div>
                                    <span class="badge bg-warning bg-opacity-10 text-warning mb-2">Design</span>
                                    <h6 class="fw-bold mb-0">การออกแบบ</h6>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100 rounded-4">
                                <div class="card-body text-center">
                                    <div class="bg-light rounded-4 p-4 mb-3">
                                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 150'%3E%3Crect fill='%23FFE8E8' width='200' height='150'/%3E%3C/svg%3E"
                                            alt="Frontend" class="img-fluid" style="max-height: 120px;">
                                    </div>
                                    <span class="badge bg-danger bg-opacity-10 text-danger mb-2">Frontend</span>
                                    <h6 class="fw-bold mb-0">พัฒนาหน้าเว็บ</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div class="col-lg-4">
                <!-- Calendar -->


                <!-- ข้อมูลบัญชีธนาคาร -->
                <div class="card border-0 shadow-sm mb-4 rounded-4">
                    <div class="card-body">
                        <h6 class="fw-normal mb-3">ข้อมูลบัญชีธนาคาร</h6>

                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-bank text-warning me-2"></i>
                                <small class="text-muted">ธนาคาร</small>
                            </div>
                            <div class="fw-normal">{{$farmer->bank_name}}</div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-credit-card text-warning me-2"></i>
                                <small class="text-muted">เลขที่บัญชี</small>
                            </div>
                            <div class="fw-normal">{{$farmer->bank_account_id}}</div>
                        </div>

                        <div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-person text-warning me-2"></i>
                                <small class="text-muted">ชื่อบัญชี</small>
                            </div>
                            <div class="fw-normal">{{$farmer->first_name}} {{$farmer->last_name}}</div>
                        </div>
                    </div>
                </div>

                <!-- ผู้ค้ำประกัน -->
                <div class="card border-0 shadow-sm mb-4 rounded-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-normal mb-0">ผู้ค้ำประกัน</h6>
                            <a href="#" class="text-primary text-decoration-none small">See All</a>
                        </div>

                        <!-- Task 1 -->
                        <div class="card bg-light border-0 mb-2 rounded-4">
                            <div class="card-body py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="bi bi-search text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-normal mb-0">Do The Research</div>
                                        <small class="text-muted">Due in 9 days</small>
                                    </div>
                                    <i class="bi bi-chevron-right text-muted"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Task 2 -->
                        <div class="card bg-light border-0 mb-2 rounded-4">
                            <div class="card-body py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="bi bi-code-slash text-info"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-normal mb-0">PHP Development</div>
                                        <small class="text-muted">Due in 2 days</small>
                                    </div>
                                    <i class="bi bi-chevron-right text-muted"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Task 3 -->
                        <div class="card bg-light border-0 mb-2 rounded-4">
                            <div class="card-body py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="bi bi-palette text-success"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-normal mb-0">Graphic Design</div>
                                        <small class="text-muted">Due in 5 days</small>
                                    </div>
                                    <i class="bi bi-chevron-right text-muted"></i>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light border-0 mb-2 rounded-4">
                            <div class="card-body py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="bi bi-palette text-success"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-normal mb-0">Graphic Design</div>
                                        <small class="text-muted">Due in 5 days</small>
                                    </div>
                                    <i class="bi bi-chevron-right text-muted"></i>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light border-0 mb-2 rounded-4">
                            <div class="card-body py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="bi bi-palette text-success"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-normal mb-0">Graphic Design</div>
                                        <small class="text-muted">Due in 5 days</small>
                                    </div>
                                    <i class="bi bi-chevron-right text-muted"></i>
                                </div>
                            </div>
                        </div>




                    </div>
                </div>

                =

            </div>
        </div>
    </div>

    <!-- Required: Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endsection
