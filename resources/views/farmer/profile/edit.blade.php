{{-- แก้ไขข้อมูล --}}
@extends('layouts.farmer.dashboard')

@section('title', 'แก้ไขข้อมูลเกษตรกร')

@section('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Prompt', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
            color: #059669;
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
            border-color: #059669;
            background: white;
            box-shadow: 0 0 0 0.2rem rgba(5, 150, 105, 0.15);
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
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
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
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="form-card">
            <div class="card shadow-lg border-0">
                <!-- Header -->
                <div class="card-header-custom text-center bg-warning bg-opacity-75">
                    <h4 class="mb-1">✏️ แก้ไขข้อมูลเกษตรกร</h4>
                    <small>กรุณาตรวจสอบข้อมูลให้ถูกต้องก่อนบันทึก</small>
                </div>

                <!-- Body -->
                <div class="card-body p-4">
                    <form action="{{ route('farmer.profile.update', $farmer->farmer_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- ข้อมูลส่วนตัว -->
                        <div class="section-title">
                            👤 ข้อมูลส่วนตัว
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">ชื่อ <span class="required">*</span></label>
                                <input type="text" class="form-control" name="first_name" 
                                       value="{{ old('first_name', $farmer->first_name) }}" 
                                       placeholder="ระบุชื่อ" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">นามสกุล <span class="required">*</span></label>
                                <input type="text" class="form-control" name="last_name" 
                                       value="{{ old('last_name', $farmer->last_name) }}" 
                                       placeholder="ระบุนามสกุล" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">📱 เบอร์โทรศัพท์ <span class="required">*</span></label>
                                <input type="tel" class="form-control" name="phone_number" 
                                       value="{{ old('phone_number', $farmer->phone_number) }}" 
                                       pattern="[0-9]{10}" placeholder="0812345678" maxlength="10" required>
                                <div class="form-text">กรอกเบอร์โทร 10 หลัก</div>
                            </div>
                        </div>

                        <!-- ที่อยู่ -->
                        <div class="section-title">
                            🏠 ที่อยู่
                        </div>

                        <div class="mb-3">
                            <label class="form-label">บ้านเลขที่ <span class="required">*</span></label>
                            <textarea class="form-control" name="address" placeholder="บ้านเลขที่ หมู่ ถนน" required>{{ old('address', $farmer->address) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">หมู่บ้าน <span class="required">*</span></label>
                            <select class="form-select" name="village_id" required>
                                <option value="1" {{ old('village_id', $farmer->village_id) == 1 ? 'selected' : '' }}>หมู่ 1</option>
                                <option value="2" {{ old('village_id', $farmer->village_id) == 2 ? 'selected' : '' }}>หมู่ 2</option>
                                <option value="3" {{ old('village_id', $farmer->village_id) == 3 ? 'selected' : '' }}>หมู่ 3</option>
                                <option value="4" {{ old('village_id', $farmer->village_id) == 4 ? 'selected' : '' }}>หมู่ 4</option>
                                <option value="5" {{ old('village_id', $farmer->village_id) == 5 ? 'selected' : '' }}>หมู่ 5</option>
                                <option value="6" {{ old('village_id', $farmer->village_id) == 6 ? 'selected' : '' }}>หมู่ 6</option>
                                <option value="7" {{ old('village_id', $farmer->village_id) == 7 ? 'selected' : '' }}>หมู่ 7</option>
                                <option value="8" {{ old('village_id', $farmer->village_id) == 8 ? 'selected' : '' }}>หมู่ 8</option>
                                <option value="9" {{ old('village_id', $farmer->village_id) == 9 ? 'selected' : '' }}>หมู่ 9</option>
                                <option value="10" {{ old('village_id', $farmer->village_id) == 10 ? 'selected' : '' }}>หมู่ 10</option>
                            </select>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">จังหวัด <span class="required">*</span></label>
                                <select class="form-control" name="province_id" id="province_select" required>
                                    <option value="">-- เลือกจังหวัด --</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->province_id }}" 
                                                {{ old('province_id', $farmer->province_id) == $province->province_id ? 'selected' : '' }}>
                                            {{ $province->name_in_thai }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">อำเภอ <span class="required">*</span></label>
                                <select class="form-control" name="district_id" id="district_select" required>
                                    <option value="">-- เลือกอำเภอ --</option>
                                    @if(isset($districts))
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->district_id }}" 
                                                    {{ old('district_id', $farmer->district_id) == $district->district_id ? 'selected' : '' }}>
                                                {{ $district->name_in_thai }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">ตำบล <span class="required">*</span></label>
                                <select class="form-control" name="subdistrict_id" id="subdistrict_select" required>
                                    <option value="">-- เลือกตำบล --</option>
                                    @if(isset($subdistricts))
                                        @foreach ($subdistricts as $subdistrict)
                                            <option value="{{ $subdistrict->subdistrict_id }}" 
                                                    data-zipcode="{{ $subdistrict->zip_code }}"
                                                    {{ old('subdistrict_id', $farmer->subdistrict_id) == $subdistrict->subdistrict_id ? 'selected' : '' }}>
                                                {{ $subdistrict->name_in_thai }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">รหัสไปรษณีย์ <span class="required">*</span></label>
                                <input type="text" class="form-control" name="zip_code" id="zip_code" 
                                       value="{{ old('zip_code', $farmer->zip_code) }}" 
                                       placeholder="รหัสไปรษณีย์" readonly required>
                            </div>
                        </div>

                        <!-- ข้อมูลพื้นที่เกษตร -->
                        <div class="section-title">
                            🌾 ข้อมูลพื้นที่เกษตร
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">📏 จำนวนไร่ <span class="required">*</span></label>
                                <input type="number" class="form-control" name="total_rai" 
                                       value="{{ old('total_rai', $farmer->total_rai) }}" 
                                       step="0.01" min="0" placeholder="0.00" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">⚖️ สิทธิ์จำนำ (กก.) <span class="required">*</span></label>
                                <input type="number" class="form-control" name="pledge_right_kg" 
                                       value="{{ old('pledge_right_kg', $farmer->pledge_right_kg) }}" 
                                       step="0.01" min="0" placeholder="0.00" required>
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
                                    {{-- <option value="">เลือกธนาคาร</option> --}}
                                    <option value="1" {{ old('bank_name_id', $farmer->bank_name_id) == 1 ? 'selected' : '' }}>ธนาคารกรุงเทพ</option>
                                    <option value="2" {{ old('bank_name_id', $farmer->bank_name_id) == 2 ? 'selected' : '' }}>ธนาคารกสิกรไทย</option>
                                    <option value="3" {{ old('bank_name_id', $farmer->bank_name_id) == 3 ? 'selected' : '' }}>ธนาคารไทยพาณิชย์</option>
                                    <option value="4" {{ old('bank_name_id', $farmer->bank_name_id) == 4 ? 'selected' : '' }}>ธนาคารกรุงไทย</option>
                                    <option value="5" {{ old('bank_name_id', $farmer->bank_name_id) == 5 ? 'selected' : '' }}>ธนาคารกรุงศรีอยุธยา</option>
                                    <option value="6" {{ old('bank_name_id', $farmer->bank_name_id) == 6 ? 'selected' : '' }}>ธนาคารทหารไทยธนชาต</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">💳 เลขที่บัญชี <span class="required">*</span></label>
                                <input type="text" class="form-control" name="bank_account_id" 
                                       value="{{ old('bank_account_id', $farmer->bank_account_id) }}" 
                                       pattern="[0-9]{10}" placeholder="1234567890" maxlength="10" required>
                                <div class="form-text">กรอกเลขบัญชี 10 หลัก</div>
                            </div>
                        </div>

                        <!-- ปุ่มบันทึก -->
                        <div class="d-flex gap-2 justify-content-center pt-3 border-top">
                            <button type="submit" class="btn btn-warning text-white">
                                💾 บันทึกการแก้ไข
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const provinceSelect = document.getElementById('province_select');
        const districtSelect = document.getElementById('district_select');
        const subdistrictSelect = document.getElementById('subdistrict_select');
        const zipCodeInput = document.getElementById('zip_code');
        const baseUrl = 'https://bservcpe.eng.kps.ku.ac.th/db25/db25_076/lara8Template/public';

        // เก็บค่าเดิมไว้
        const currentProvinceId = '{{ old('province_id', $farmer->province_id ?? '') }}';
        const currentDistrictId = '{{ old('district_id', $farmer->district_id ?? '') }}';
        const currentSubdistrictId = '{{ old('subdistrict_id', $farmer->subdistrict_id ?? '') }}';

        // เมื่อเลือกจังหวัด
        provinceSelect.addEventListener('change', function() {
            const provinceId = this.value;
            
            districtSelect.innerHTML = '<option value="">-- กำลังโหลดอำเภอ... --</option>';
            subdistrictSelect.innerHTML = '<option value="">-- เลือกตำบล --</option>';
            zipCodeInput.value = '';

            if (provinceId) {
                fetch(`${baseUrl}/get-districts/${provinceId}`)
                    .then(response => response.json())
                    .then(data => {
                        districtSelect.innerHTML = '<option value="">-- เลือกอำเภอ --</option>';
                        data.forEach(district => {
                            const option = document.createElement('option');
                            option.value = district.district_id;
                            option.textContent = district.name_in_thai;
                            if (district.district_id == currentDistrictId) {
                                option.selected = true;
                            }
                            districtSelect.appendChild(option);
                        });

                        // ถ้ามีค่าเดิม ให้โหลดตำบลด้วย
                        if (currentDistrictId && provinceId == currentProvinceId) {
                            districtSelect.dispatchEvent(new Event('change'));
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching districts:', error);
                        districtSelect.innerHTML = '<option value="">-- เกิดข้อผิดพลาด --</option>';
                    });
            } else {
                districtSelect.innerHTML = '<option value="">-- เลือกอำเภอ --</option>';
            }
        });

        // เมื่อเลือกอำเภอ
        districtSelect.addEventListener('change', function() {
            const districtId = this.value;

            subdistrictSelect.innerHTML = '<option value="">-- กำลังโหลดตำบล... --</option>';
            zipCodeInput.value = '';

            if (districtId) {
                fetch(`${baseUrl}/get-subdistricts/${districtId}`)
                    .then(response => response.json())
                    .then(data => {
                        subdistrictSelect.innerHTML = '<option value="">-- เลือกตำบล --</option>';
                        data.forEach(subdistrict => {
                            const option = document.createElement('option');
                            option.value = subdistrict.subdistrict_id;
                            option.textContent = subdistrict.name_in_thai;
                            option.setAttribute('data-zipcode', subdistrict.zip_code);
                            if (subdistrict.subdistrict_id == currentSubdistrictId) {
                                option.selected = true;
                            }
                            subdistrictSelect.appendChild(option);
                        });

                        // ถ้ามีค่าเดิม ให้โหลดรหัสไปรษณีย์ด้วย
                        if (currentSubdistrictId && districtId == currentDistrictId) {
                            subdistrictSelect.dispatchEvent(new Event('change'));
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching subdistricts:', error);
                        subdistrictSelect.innerHTML = '<option value="">-- เกิดข้อผิดพลาด --</option>';
                    });
            } else {
                subdistrictSelect.innerHTML = '<option value="">-- เลือกตำบล --</option>';
            }
        });

        // เมื่อเลือกตำบล
        subdistrictSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const zipCode = selectedOption.getAttribute('data-zipcode');
            
            console.log('📮 รหัสไปรษณีย์:', zipCode);
            
            if (zipCode) {
                zipCodeInput.value = zipCode;
                console.log('✅ กรอกรหัสไปรษณีย์อัตโนมัติ:', zipCode);
            } else {
                zipCodeInput.value = '';
                console.warn('⚠️ ไม่พบรหัสไปรษณีย์');
            }
        });

        // โหลดข้อมูลเดิมตอนเปิดหน้า (ถ้ามีจังหวัดเดิม)
        if (currentProvinceId) {
            provinceSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endsection