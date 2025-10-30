@extends('layouts.farmer.dashboard')
@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    
    <style>
        /** ✅ ตารางเกษตรกร **/
        .table-container {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-top: 20px;
        }

        table.dataTable {
            width: 100% !important;
            font-weight: 300;
        }

        table.dataTable th,
        table.dataTable td {
            padding: 12px 15px;
            border-bottom: 1px solid #e5e5e5;
        }

        table.dataTable thead th {
            background-color: #f7f7f7;
            color: #333;
            font-weight: 500;
            border-bottom: 2px solid #dee2e6;
        }

        table.dataTable tbody tr:hover {
            background-color: #f9f9f9;
        }

        /* DataTables Custom Styling */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 15px;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 6px 12px;
            margin-left: 8px;
        } */

        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 4px 8px;
            margin: 0 8px;
        }

        /* .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 6px 12px;
            margin: 0 2px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
        } */

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #5c6bc0;
            color: white !important;
            border-color: #5c6bc0;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f5f5f5;
            border-color: #dee2e6;
        }

        .dataTables_wrapper .dataTables_info {
            padding-top: 15px;
            font-size: 14px;
            color: #666;
        }

        /** ✅ Custom Filter Section **/
        .filter-section {
            background: #f8f9fa;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
        }

        .filter-section .row {
            align-items: center;
        }

        .filter-section label {
            font-size: 14px;
            font-weight: 500;
            color: #495057;
            margin-bottom: 5px;
            display: block;
        }

        .filter-section .btn-reset {
            padding: 8px 20px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            background: white;
            color: #666;
            font-size: 14px;
            transition: all 0.2s;
        }

        .filter-section .btn-reset:hover {
            background: #f8f9fa;
            border-color: #adb5bd;
        }

        .select2-container--bootstrap-5 .select2-selection {
            min-height: 38px;
            border-radius: 6px;
            border-color: #dee2e6;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
           
            line-height: 1.5;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        .select2-container--bootstrap-5.select2-container--focus .select2-selection,
        .select2-container--bootstrap-5.select2-container--open .select2-selection {
            border-color: #5c6bc0;
            box-shadow: 0 0 0 0.2rem rgba(92, 107, 192, 0.15);
        }

        .select2-container--bootstrap-5 .select2-dropdown {
            border-color: #dee2e6;
            border-radius: 6px;
        }

        .select2-container--bootstrap-5 .select2-results__option--highlighted {
            background-color: #5c6bc0;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__placeholder {
            color: #6c757d;
            /* โค้ดที่เพิ่ม: จัดข้อความ placeholder ให้อยู่กึ่งกลาง */
            text-align: center; 
            /* เพื่อให้แน่ใจว่ามันจะทำงาน แม้จะมี padding/margin อื่นๆ */
            width: 100%; 
        }

        /** ✅ สถานะแบบ Badge/Pill **/
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            white-space: nowrap;
        }

        .status-badge::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        /* สถานะ Invited (สีเขียว) */
        .status-invited {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .status-invited::before {
            background-color: #4caf50;
        }

        /* สถานะ Absent (สีเทา) */
        .status-absent {
            background-color: #f5f5f5;
            color: #616161;
        }

        .status-absent::before {
            background-color: #9e9e9e;
        }

        /** ✅ Action Buttons - Minimal Style **/
        .action-buttons {
            display: flex;
            gap: 4px;
            justify-content: center;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            border: none;
            background: transparent;
            color: #9e9e9e;
            transition: all 0.2s ease;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-action:hover {
            background-color: #f5f5f5;
        }

        .btn-view {
            color: #5c6bc0;
        }

        .btn-edit {
            color: #ffa726;
        }

        .btn-delete {
            color: #ef5350;
        }

        /* Header Section */
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header-section h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 500;
        }
    </style>
@endsection

@section('content')
    <div class="table-container">
        <div class="header-section">
            <h2>📋 รายชื่อเกษตรกร</h2>
            <a href="{{ route('farmer.profile.create') }}" class="btn btn-light border" style="color: #5c6bc0;">
                <i class="bi bi-plus-circle me-1"></i> เพิ่มเกษตรกร
            </a>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="filterProvince">
                        <i class="bi bi-geo-alt-fill me-1"></i>จังหวัด
                    </label>
                    <select id="filterProvince" >
                        <option value="">ทั้งหมด</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->province_id }}">{{ $province->name_in_thai }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filterDistrict">
                        <i class="bi bi-pin-map-fill me-1"></i>อำเภอ
                    </label>
                    <select id="filterDistrict"  disabled style="padding:0px"> 
                        <option value="">เลือกจังหวัดก่อน</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filterSubDistrict">
                        <i class="bi bi-house-fill me-1"></i>ตำบล
                    </label>
                    <select id="filterSubDistrict"  disabled>
                        <option value="">เลือกอำเภอก่อน</option>
                    </select>
                </div>
                {{-- <div class="col-md-3 d-flex align-items-end">
                    <button id="resetFilter" class="btn btn-reset w-100">
                        <i class="bi bi-arrow-clockwise me-1"></i> ล้างตัวกรอง
                    </button>
                </div> --}}
            </div>
        </div>

        <table id="farmersTable" class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ชื่อ</th>
                    <th>นามสกุล</th>
                    <th>สิทธิ์จำนำ (กก.)</th>
                    <th>ใช้สิทธิ์แล้ว (กก.)</th>
                    <th>คงเหลือ (กก.)</th>
                    <th>สถานะรับรอง</th>
                    <th class="text-center">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($farmers as $farmer)
                    <tr data-province-id="{{ $farmer->province_id ?? '' }}" 
                        data-district-id="{{ $farmer->district_id ?? '' }}" 
                        data-subdistrict-id="{{ $farmer->subdistrict_id ?? '' }}">
                        <td>{{ $farmer->farmer_id }}</td>
                        <td>{{ $farmer->first_name }}</td>
                        <td>{{ $farmer->last_name }}</td>
                        <td data-order="{{ $farmer->pledge_right_kg }}">{{ number_format($farmer->pledge_right_kg, 2) }}</td>
                        <td data-order="{{ $farmer->pledged_amount_kg }}">{{ number_format($farmer->pledged_amount_kg, 2) }}</td>
                        <td data-order="{{ $farmer->remaining_right_kg }}">{{ number_format($farmer->remaining_right_kg, 2) }}</td>
                        <td data-order="{{ $farmer->is_certified ? 1 : 0 }}">
                            @if ($farmer->verification_status)
                                <span class="status-badge status-invited">รับรองแล้ว</span>
                            @else
                                <span class="status-badge status-absent">ยังไม่รับรอง</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                {{-- ปุ่มดู --}}
                                <a href="{{ route('farmer.profile.show', $farmer->farmer_id) }}"
                                    class="btn-action btn-view bg-info-subtle" title="ดูข้อมูล">
                                    <i class="bi bi-eye"></i>
                                </a>

                                {{-- ปุ่มแก้ไข --}}
                                <a href="{{ route('farmer.profile.edit', $farmer->farmer_id) }}"
                                    class="btn-action btn-edit bg-warning-subtle" title="แก้ไขข้อมูล">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                {{-- ปุ่มลบ --}}
                                <button type="button" onclick="confirmDelete({{ $farmer->farmer_id }})"
                                    class="btn-action btn-delete bg-danger-subtle" title="ลบข้อมูล">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <!-- jQuery (required for DataTables and Select2) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Base URL สำหรับ API
        const baseUrl = 'https://bservcpe.eng.kps.ku.ac.th/db25/db25_076/lara8Template/public';

        $(document).ready(function() {
            // Initialize Select2
            $('#filterProvince').select2({
                theme: "bootstrap-5",
                width: '100%',
                placeholder: 'เลือกจังหวัด',
                allowClear: true
            });

            $('#filterDistrict').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'เลือกอำเภอ',
                allowClear: true
            });

            $('#filterSubDistrict').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'เลือกตำบล',
                allowClear: true
            });

            // Initialize DataTable
            var table = $('#farmersTable').DataTable({
                language: {
                    "sProcessing": "กำลังดำเนินการ...",
                    "sLengthMenu": "แสดง _MENU_ รายการ",
                    "sZeroRecords": "ไม่พบข้อมูล",
                    "sInfo": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 รายการ",
                    "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกรายการ)",
                    "sSearch": "ค้นหา:",
                    "oPaginate": {
                        "sFirst": "หน้าแรก",
                        "sPrevious": "ก่อนหน้า",
                        "sNext": "ถัดไป",
                        "sLast": "หน้าสุดท้าย"
                    }
                },
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "ทั้งหมด"]],
                order: [[0, 'asc']],
                responsive: true,
                columnDefs: [
                    { 
                        orderable: false, 
                        targets: 7 // ปิดการเรียงลำดับคอลัมน์ "จัดการ"
                    },
                    { 
                        orderable: false, 
                        targets: [1, 2] // ⭐ โค้ดที่เพิ่ม: ปิดการเรียงลำดับคอลัมน์ "ชื่อ" (Index 1) และ "นามสกุล" (Index 2)
                    }
                ]
            });

            // เก็บ ID ของจังหวัด อำเภอ ตำบลที่เลือก
            let selectedProvinceId = '';
            let selectedDistrictId = '';
            let selectedSubDistrictId = '';

            // Custom filtering function
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var row = table.row(dataIndex).node();
                    var rowProvinceId = $(row).data('province-id') || '';
                    var rowDistrictId = $(row).data('district-id') || '';
                    var rowSubDistrictId = $(row).data('subdistrict-id') || '';

                    // ถ้าไม่มีการเลือก filter ให้แสดงทั้งหมด
                    if (!selectedProvinceId && !selectedDistrictId && !selectedSubDistrictId) {
                        return true;
                    }

                    // Check if all filters match
                    if (
                        (!selectedProvinceId || rowProvinceId == selectedProvinceId) &&
                        (!selectedDistrictId || rowDistrictId == selectedDistrictId) &&
                        (!selectedSubDistrictId || rowSubDistrictId == selectedSubDistrictId)
                    ) {
                        return true;
                    }
                    return false;
                }
            );

            // ⭐ เมื่อเลือกจังหวัด
            $('#filterProvince').on('change', function() {
                const provinceId = $(this).val();
                selectedProvinceId = provinceId;
                
                // Reset อำเภอและตำบล
                $('#filterDistrict').empty().append('<option value="">กำลังโหลด...</option>').prop('disabled', true).trigger('change');
                $('#filterSubDistrict').empty().append('<option value="">เลือกอำเภอก่อน</option>').prop('disabled', true).trigger('change');
                selectedDistrictId = '';
                selectedSubDistrictId = '';

                if (provinceId) {
                    // ดึงข้อมูลอำเภอจาก API
                    fetch(`${baseUrl}/get-districts/${provinceId}`)
                        .then(response => response.json())
                        .then(data => {
                            let options = '<option value="">ทั้งหมด</option>';
                            data.forEach(district => {
                                options += `<option value="${district.district_id}">${district.name_in_thai}</option>`;
                            });
                            $('#filterDistrict').html(options).prop('disabled', false).trigger('change');
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            $('#filterDistrict').html('<option value="">เกิดข้อผิดพลาด</option>').trigger('change');
                        });
                } else {
                    selectedProvinceId = '';
                    $('#filterDistrict').html('<option value="">เลือกจังหวัดก่อน</option>').prop('disabled', true).trigger('change');
                }

                // Filter ตาราง
                table.draw();
            });

            // ⭐ เมื่อเลือกอำเภอ
            $('#filterDistrict').on('change', function() {
                const districtId = $(this).val();
                selectedDistrictId = districtId;
                
                // Reset ตำบล
                $('#filterSubDistrict').empty().append('<option value="">กำลังโหลด...</option>').prop('disabled', true).trigger('change');
                selectedSubDistrictId = '';

                if (districtId) {
                    // ดึงข้อมูลตำบลจาก API
                    fetch(`${baseUrl}/get-subdistricts/${districtId}`)
                        .then(response => response.json())
                        .then(data => {
                            let options = '<option value="">ทั้งหมด</option>';
                            data.forEach(subDistrict => {
                                options += `<option value="${subDistrict.subdistrict_id}">${subDistrict.name_in_thai}</option>`;
                            });
                            $('#filterSubDistrict').html(options).prop('disabled', false).trigger('change');
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            $('#filterSubDistrict').html('<option value="">เกิดข้อผิดพลาด</option>').trigger('change');
                        });
                } else {
                    selectedDistrictId = '';
                    $('#filterSubDistrict').html('<option value="">เลือกอำเภอก่อน</option>').prop('disabled', true).trigger('change');
                }

                // Filter ตาราง
                table.draw();
            });

            // ⭐ เมื่อเลือกตำบล
            $('#filterSubDistrict').on('change', function() {
                const subDistrictId = $(this).val();
                selectedSubDistrictId = subDistrictId;
                
                // Filter ตาราง
                table.draw();
            });

            // ⭐ ปุ่ม Reset
            $('#resetFilter').on('click', function() {
                // Reset Select2
                $('#filterProvince').val('').trigger('change');
                $('#filterDistrict').empty().append('<option value="">เลือกจังหวัดก่อน</option>').prop('disabled', true).trigger('change');
                $('#filterSubDistrict').empty().append('<option value="">เลือกอำเภอก่อน</option>').prop('disabled', true).trigger('change');
                
                selectedProvinceId = '';
                selectedDistrictId = '';
                selectedSubDistrictId = '';
                
                table.draw();
            });
        });

        // ฟังก์ชันยืนยันการลบ
        function confirmDelete(farmerId) {
            if (confirm('คุณต้องการลบข้อมูลเกษตรกรนี้ใช่หรือไม่?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/farmer/profile/' + farmerId;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';

                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection