{{-- เพิ่มข้อมูล --}}
@extends('layouts.farmer.dashboard')

@section('title', 'เพิ่มข้อมูลเกษตรกร')

@section('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <style>
        * {
            font-family: 'Prompt', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            min-height: 100vh;
        }

        .form-card {
            max-width: 700px;
            margin: 30px auto;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-header-custom {
            color: white;
            padding: 24px;
            border-bottom: none;
        }

        .section-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #2563eb;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e9ecef;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-control,
        .form-select {
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            background: #fafafa;
        }

        .form-control:hover,
        .form-select:hover {
            border-color: #d1d5db;
            background: white;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.15);
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }

        .required {
            color: #dc3545;
        }

        .btn-success-custom {
            border: none;
            padding: 10px 28px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-success-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-secondary {
            padding: 10px 28px;
            font-weight: 500;
        }

        .form-text {
            font-size: 0.8rem;
            color: #6c757d;
        }

        textarea.form-control {
            min-height: 80px;
            resize: vertical;
        }

        /* Select2 Custom Styling - Blue Theme */
        .select2-container--bootstrap-5 .select2-selection {
            border: 1.5px solid #e5e7eb !important;
            border-radius: 8px !important;
            min-height: 42px !important;
            background: #fafafa !important;
            transition: all 0.2s ease;
        }

        .select2-container--bootstrap-5 .select2-selection:hover {
            border-color: #d1d5db !important;
            background: white !important;
        }

        .select2-container--bootstrap-5.select2-container--focus .select2-selection,
        .select2-container--bootstrap-5.select2-container--open .select2-selection {
            border-color: #3b82f6 !important;
            background: white !important;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.15) !important;
        }

        .select2-container--bootstrap-5 .select2-selection__rendered {
            padding: 2px 12px !important;
            font-size: 0.9rem !important;
            color: #374151;
        }

        .select2-container--bootstrap-5 .select2-selection__placeholder {
            color: #9ca3af !important;
        }

        .select2-container--bootstrap-5 .select2-dropdown {
            border: 1.5px solid #3b82f6 !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15) !important;
        }

        .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
            border: 1.5px solid #e5e7eb !important;
            border-radius: 6px !important;
            padding: 8px 12px !important;
            font-size: 0.9rem !important;
        }

        .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field:focus {
            border-color: #3b82f6 !important;
            outline: none !important;
            box-shadow: 0 0 0 0.15rem rgba(59, 130, 246, 0.15) !important;
        }

        .select2-container--bootstrap-5 .select2-results__option {
            padding: 10px 12px !important;
            font-size: 0.9rem !important;
        }

        .select2-container--bootstrap-5 .select2-results__option--highlighted {
            background-color: #dbeafe !important;
            color: #1e40af !important;
        }

        .select2-container--bootstrap-5 .select2-results__option--selected {
            background-color: #3b82f6 !important;
            color: white !important;
        }

        /* Loading Icon */
        .select2-container--bootstrap-5 .select2-selection__arrow {
            height: 40px !important;
        }

        /* ไอคอนสำหรับ Label */
        .label-with-icon {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .label-with-icon i {
            color: #3b82f6;
            font-size: 1rem;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="form-card">
            <div class="card shadow-lg border-0">
                <!-- Header -->
                <div class="card-header-custom text-center bg-primary bg-opacity-75">
                    <h4 class="mb-1">📝 เพิ่มข้อมูลเกษตรกร</h4>
                    <small>กรุณากรอกข้อมูลให้ครบถ้วนและถูกต้อง</small>
                </div>

                <!-- Body -->
                <div class="card-body p-4">
                    <form action="{{ route('farmer.profile.store') }}" method="POST">
                        @csrf

                        <!-- ข้อมูลส่วนตัว -->
                        <div class="section-title">
                            👤 ข้อมูลส่วนตัว
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">ชื่อ <span class="required">*</span></label>
                                <input type="text" class="form-control" name="first_name" placeholder="ระบุชื่อ"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">นามสกุล <span class="required">*</span></label>
                                <input type="text" class="form-control" name="last_name" placeholder="ระบุนามสกุล"
                                    required>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">📱 เบอร์โทรศัพท์ <span class="required">*</span></label>
                                <input type="tel" class="form-control" name="phone_number" pattern="[0-9]{10}"
                                    placeholder="0812345678" maxlength="10" required>
                                <div class="form-text">กรอกเบอร์โทร 10 หลัก</div>
                            </div>
                        </div>

                        <!-- ที่อยู่ -->
                        <div class="section-title">
                            🏠 ที่อยู่
                        </div>

                        <div class="mb-3">
                            <label class="form-label">บ้านเลขที่ <span class="required">*</span></label>
                            <textarea class="form-control" name="address" placeholder="บ้านเลขที่ หมู่ ถนน" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">🏘️ หมู่บ้าน <span class="required">*</span></label>
                            <select class="form-control select2-dropdown" name="village_id" id="village_select" required>
                                <option></option>
                                <option value="1">หมู่ 1</option>
                                <option value="2">หมู่ 2</option>
                                <option value="3">หมู่ 3</option>
                                <option value="4">หมู่ 4</option>
                                <option value="5">หมู่ 5</option>
                                <option value="6">หมู่ 6</option>
                                <option value="7">หมู่ 7</option>
                                <option value="8">หมู่ 8</option>
                                <option value="9">หมู่ 9</option>
                                <option value="10">หมู่ 10</option>
                            </select>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">
                                    🗺️ จังหวัด <span class="required">*</span>
                                </label>
                                <select class="form-control select2-dropdown" name="province_id" id="province_select" required>
                                    <option></option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->province_id }}">{{ $province->name_in_thai }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    🏘️ อำเภอ <span class="required">*</span>
                                </label>
                                <select class="form-control select2-dropdown" name="district_id" id="district_select" required disabled>
                                    <option></option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">
                                    📍 ตำบล <span class="required">*</span>
                                </label>
                                <select class="form-control select2-dropdown" name="subdistrict_id" id="subdistrict_select" required disabled>
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">📮 รหัสไปรษณีย์ <span class="required">*</span></label>
                                <input type="text" class="form-control" name="zip_code" placeholder="รหัสไปรษณีย์"
                                    required id="zip_code" readonly>
                            </div>
                        </div>

                        <!-- ข้อมูลพื้นที่เกษตร -->
                        <div class="section-title">
                            🌾 ข้อมูลพื้นที่เกษตร
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">📏 จำนวนไร่ <span class="required">*</span></label>
                                <input type="number" class="form-control" name="total_rai" step="0.01" min="0"
                                    placeholder="0.00" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">⚖️ สิทธิ์จำนำ (กก.) <span class="required">*</span></label>
                                <input type="number" class="form-control" name="pledge_right_kg" step="0.01"
                                    min="0" placeholder="0.00" required>
                            </div>
                        </div>

                        <!-- ข้อมูลบัญชีธนาคาร -->
                        <div class="section-title">
                            🏦 ข้อมูลบัญชีธนาคาร
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">ธนาคาร <span class="required">*</span></label>
                                <select class="form-select" name="bank_name_id" required>
                                    <option value="">เลือกธนาคาร</option>
                                    <option value="1">ธนาคารกรุงเทพ</option>
                                    <option value="2">ธนาคารกสิกรไทย</option>
                                    <option value="3">ธนาคารไทยพาณิชย์</option>
                                    <option value="4">ธนาคารกรุงไทย</option>
                                    <option value="5">ธนาคารกรุงศรีอยุธยา</option>
                                    <option value="6">ธนาคารทหารไทยธนชาต</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">💳 เลขที่บัญชี <span class="required">*</span></label>
                                <input type="text" class="form-control" name="bank_account_id" pattern="[0-9]{10}"
                                    placeholder="เลขบัญชี" maxlength="10" required>
                                <div class="form-text">กรอกเลขบัญชี 10 หลัก</div>
                                @error('bank_account_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- ปุ่มบันทึก -->
                        <div class="d-flex gap-2 justify-content-center pt-3 border-top">
                            <button type="submit" class="btn btn-primary text-white bg-opacity-75">
                                💾 บันทึกข้อมูล
                            </button>
                            <a href="{{ route('farmer.profile.index') }}" class="btn btn-secondary">
                                ← ยกเลิก
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- jQuery (Required for Select2) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    {{-- Select2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // กำหนด Base URL
            const baseUrl = 'https://bservcpe.eng.kps.ku.ac.th/db25/db25_076/lara8Template/public';

            // เริ่มต้น Select2 สำหรับหมู่บ้าน
            $('#village_select').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'ค้นหาหรือเลือกหมู่บ้าน',
                allowClear: false,
                language: {
                    noResults: function() {
                        return "ไม่พบข้อมูล";
                    },
                    searching: function() {
                        return "กำลังค้นหา...";
                    }
                }
            });

            // เริ่มต้น Select2 สำหรับจังหวัด
            $('#province_select').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'ค้นหาหรือเลือกจังหวัด',
                allowClear: false,
                language: {
                    noResults: function() {
                        return "ไม่พบข้อมูล";
                    },
                    searching: function() {
                        return "กำลังค้นหา...";
                    }
                }
            });

            // เริ่มต้น Select2 สำหรับอำเภอ
            $('#district_select').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'ค้นหาหรือเลือกอำเภอ',
                allowClear: false,
                language: {
                    noResults: function() {
                        return "ไม่พบข้อมูล";
                    },
                    searching: function() {
                        return "กำลังค้นหา...";
                    }
                }
            });

            // เริ่มต้น Select2 สำหรับตำบล
            $('#subdistrict_select').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'ค้นหาหรือเลือกตำบล',
                allowClear: false,
                language: {
                    noResults: function() {
                        return "ไม่พบข้อมูล";
                    },
                    searching: function() {
                        return "กำลังค้นหา...";
                    }
                }
            });

            // เมื่อเลือกจังหวัด
            $('#province_select').on('change', function() {
                const provinceId = $(this).val();
                const districtSelect = $('#district_select');
                const subdistrictSelect = $('#subdistrict_select');
                const zipCodeInput = $('#zip_code');

                // รีเซ็ตอำเภอและตำบล
                districtSelect.empty().append('<option></option>').prop('disabled', true).trigger('change');
                subdistrictSelect.empty().append('<option></option>').prop('disabled', true).trigger('change');
                zipCodeInput.val('');

                if (provinceId) {
                    $.ajax({
                        url: `${baseUrl}/get-districts/${provinceId}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            districtSelect.empty().append('<option></option>');
                            
                            $.each(data, function(index, district) {
                                districtSelect.append(
                                    $('<option></option>')
                                        .attr('value', district.district_id)
                                        .text(district.name_in_thai)
                                );
                            });
                            
                            districtSelect.prop('disabled', false).trigger('change');
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            alert('เกิดข้อผิดพลาดในการโหลดข้อมูลอำเภอ');
                        }
                    });
                }
            });

            // เมื่อเลือกอำเภอ
            $('#district_select').on('change', function() {
                const districtId = $(this).val();
                const subdistrictSelect = $('#subdistrict_select');
                const zipCodeInput = $('#zip_code');

                subdistrictSelect.empty().append('<option value=""></option>').prop('disabled', true).trigger('change');
                zipCodeInput.val('');

                if (districtId) {
                    $.ajax({
                        url: `${baseUrl}/get-subdistricts/${districtId}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            subdistrictSelect.empty().append('<option value=""></option>');
                            
                            $.each(data, function(index, subdistrict) {
                                subdistrictSelect.append(
                                    $('<option></option>')
                                        .attr('value', subdistrict.subdistrict_id)
                                        .attr('data-zipcode', subdistrict.zip_code)
                                        .text(subdistrict.name_in_thai)
                                );
                            });
                            
                            subdistrictSelect.prop('disabled', false).trigger('change');
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            alert('เกิดข้อผิดพลาดในการโหลดข้อมูลตำบล');
                        }
                    });
                }
            });

            // เมื่อเลือกตำบล - อัพเดทรหัสไปรษณีย์
            $('#subdistrict_select').on('change', function() {
                const selectedOption = $(this).find('option:selected');
                const zipCode = selectedOption.data('zipcode');
                
                if (zipCode) {
                    $('#zip_code').val(zipCode);
                    console.log('✅ กรอกรหัสไปรษณีย์อัตโนมัติ:', zipCode);
                } else {
                    $('#zip_code').val('');
                }
            });
        });
    </script>
@endsection