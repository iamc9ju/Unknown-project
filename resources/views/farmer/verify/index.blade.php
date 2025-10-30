@extends('layouts.farmer.dashboard')

@section('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    
    <style>
        /* ส่วนเพิ่มเติม: จัดข้อความ placeholder ให้อยู่กึ่งกลาง */
        #search-pending::placeholder {
            text-align: center;
        }

        /* สำหรับ Browser เก่าที่อาจจะยังใช้ Prefixes */
        #search-pending::-webkit-input-placeholder { /* Chrome, Safari */
            text-align: center;
        }

        #search-pending:-moz-placeholder { /* Firefox 18- */
            text-align: center;
        }

        #search-pending::-moz-placeholder { /* Firefox 19+ */
            text-align: center;
        }

        #search-pending:-ms-input-placeholder { /* Internet Explorer */
            text-align: center;
        }

        
        #pending-farmers-table {
            font-size: 14px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        #pending-farmers-table thead th {
            color: white;
            font-weight: 600;
            font-size: 13px;
            vertical-align: middle;
            padding: 12px 8px;
            text-align: center;
            border: none;
            letter-spacing: 0.3px;
            cursor: pointer;
        }

        /* สไตล์สำหรับ DataTables sorting */
        #pending-farmers-table thead th.sorting,
        #pending-farmers-table thead th.sorting_asc,
        #pending-farmers-table thead th.sorting_desc {
            position: relative;
            padding-right: 30px;
        }

        #pending-farmers-table thead th.sorting:before,
        #pending-farmers-table thead th.sorting:after,
        #pending-farmers-table thead th.sorting_asc:before,
        #pending-farmers-table thead th.sorting_desc:after {
            position: absolute;
            right: 8px;
            display: inline-block;
            opacity: 0.6;
        }

        #pending-farmers-table thead th.sorting_asc:before {
            content: "▲";
            opacity: 1;
            color: #ffc107;
        }

        #pending-farmers-table thead th.sorting_desc:after {
            content: "▼";
            opacity: 1;
            color: #ffc107;
        }

        #pending-farmers-table tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid #e9ecef;
        }

        #pending-farmers-table tbody tr:hover {
            background-color: #f8f9fc;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
        }

        #pending-farmers-table tbody td {
            vertical-align: middle;
            padding: 12px 8px;
            font-size: 14px;
        }

        #pending-farmers-table tbody td:nth-child(1) {
            font-weight: 600;
            color: #6c757d;
            font-size: 13px;
        }

        #pending-farmers-table tbody td:nth-child(2) {
            font-family: 'Courier New', monospace;
            font-weight: 500;
            color: #495057;
            font-size: 13px;
        }

        #pending-farmers-table tbody td:nth-child(3) {
            font-weight: 500;
            color: #212529;
            font-size: 14px;
        }

        #pending-farmers-table tbody td:nth-child(4) {
            font-size: 13px;
            color: #6c757d;
        }

        #pending-farmers-table tbody td:nth-child(5),
        #pending-farmers-table tbody td:nth-child(6) {
            font-weight: 600;
            color: #495057;
            font-size: 14px;
        }

        #pending-farmers-table tbody td:nth-child(8) {
            font-size: 12px;
            line-height: 1.6;
        }

        #pending-farmers-table .badge {
            font-size: 11px;
            font-weight: 600;
            padding: 4px 8px;
            letter-spacing: 0.3px;
        }

        #pending-farmers-table small {
            font-size: 12px;
            display: block;
            margin-bottom: 2px;
        }

        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }

        /* ซ่อน DataTables default search box */
        .dataTables_filter {
            display: none;
        }

        /* ปรับแต่ง DataTables pagination */
        .dataTables_wrapper .dataTables_paginate {
            padding-top: 15px;
        }

        .dataTables_wrapper .dataTables_info {
            padding-top: 20px;
            font-size: 14px;
            color: #6c757d;
        }

        button[onclick^="approveFarmer"]:hover {
            transform: translateY(-2px);
        }

        button[onclick^="approveFarmer"]:active {
            transform: translateY(0);
        }

        button[onclick^="approveFarmer"]::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        button[onclick^="approveFarmer"]:hover::before {
            left: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid p-4 bg-white rounded-4">
        <h2>รับรองเกษตรกร</h2>
        <p class="text-muted">เลือกเกษตรกรที่จะทำการรับรองและเลือกผู้ที่รอการรับรอง</p>

        <!-- ส่วนเลือกผู้รับรอง -->
        <div class="card mb-4">
            <div class="card-header bg-primary bg-opacity-75 text-white ">
                <h5 class="mb-0 fw-normal">เลือกเกษตรกรที่เป็นผู้รับรอง</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <label>เลือกเกษตรกร</label>
                        <select id="approver-select" class="form-control" style="width: 100%;">
                            <option value="">-- เลือกเกษตรกรที่จะเป็นผู้รับรอง --</option>
                            @foreach ($allFarmers as $farmer)
                                <option value="{{ $farmer->farmer_id }}" data-address="{{ $farmer->address }}"
                                    data-village="{{ $farmer->village_name }}"
                                    data-subdistrict="{{ $farmer->subdistrict_name }}"
                                    data-district="{{ $farmer->district_name }}"
                                    data-province="{{ $farmer->province_name }}" data-zip_code="{{ $farmer->zip_code }}">
                                    {{ $farmer->first_name }} {{ $farmer->last_name }} - {{ $farmer->address }}
                                    {{ $farmer->village_name }} ต.{{ $farmer->subdistrict_name }}
                                    {{ $farmer->district_name }}
                                    {{ $farmer->province_name }} {{ $farmer->subdistrict_zip_code }}
                                    (รหัส: {{ $farmer->farmer_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- แสดงข้อมูลผู้รับรองที่เลือก -->
                <div id="selected-approver-info" class="mt-3 alert alert-info" style="display: none;">
                    <h6>ผู้รับรอง:</h6>
                    <p class="mb-0">
                        <strong id="approver-name"></strong><br>
                        <small id="approver-address"></small>
                    </p>
                </div>
            </div>
        </div>

        <!-- ส่วนแสดงรายการที่รอการรับรอง -->
        <div id="pending-farmers-section" style="display: none;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>เกษตรกรที่รอการรับรอง <span id="pending-count" class="badge badge-warning">0</span></h4>

                <!-- ช่องค้นหา -->
                <div class="form-inline">
                    <input type="text" id="search-pending" class="form-control"
                        placeholder="ค้นหา (ชื่อ, นามสกุล, รหัส)">
                </div>
            </div>

            <!-- ตารางแสดงรายการเกษตรกร -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="pending-farmers-table">
                    <thead class="thead-light">
                        <tr class="bg-primary bg-opacity-75">
                            <th width="5%" class="text-center bg-primary bg-opacity-25">ลำดับ</th>
                            <th width="10%" class="bg-primary bg-opacity-25">รหัสเกษตรกร</th>
                            <th width="15%" class="bg-primary bg-opacity-25">ชื่อ-นามสกุล</th>
                            <th width="12%" class="bg-primary bg-opacity-25">หมู่บ้าน</th>
                            <th width="8%" class="text-center bg-primary bg-opacity-25">พื้นที่ (ไร่)</th>
                            <th width="10%" class="text-center bg-primary bg-opacity-25">ปริมาณข้าว (กก.)</th>
                            <th width="10%" class="text-center bg-primary bg-opacity-25">สถานะ</th>
                            <th width="20%" class="bg-primary bg-opacity-25">ผู้รับรอง</th>
                            <th width="10%" class="text-center bg-primary bg-opacity-25">การดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody id="pending-farmers-list">
                        <!-- รายการจะแสดงที่นี่ผ่าน JavaScript -->
                    </tbody>
                </table>
            </div>

            <div id="no-pending-farmers" class="alert alert-info text-center" style="display: none;">
                ไม่มีเกษตรกรที่รอการรับรองในหมู่บ้านนี้
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>

    <script>
        let selectedVerifierId = null;
        let pendingFarmersData = [];
        let dataTable = null;

        $(document).ready(function() {

            // เริ่มต้น Select2
            $('#approver-select').select2({
                placeholder: '-- เลือกเกษตรกรที่จะเป็นผู้รับรอง --',
                allowClear: true,
                width: '100%'
            });

            // เมื่อเลือกเกษตรกร
            $('#approver-select').on('change', function() {
                const verifierId = $(this).val();
                const option = $(this).find('option:selected');

                if (verifierId) {
                    selectedVerifierId = verifierId;
                    loadPendingFarmers(selectedVerifierId);

                    // แสดงข้อมูลผู้รับรอง
                    $('#approver-name').text(option.text().split(' - ')[0]);
                    $('#approver-address').text(
                        `${option.data('address')} ${option.data('village')} ตำบล ${option.data('subdistrict')} ` +
                        `อำเภอ ${option.data('district')} จังหวัด${option.data('province')} รหัสไปรษณีย์ ${option.data('zip_code')}`
                    );
                    $('#selected-approver-info').slideDown();
                } else {
                    selectedVerifierId = null;
                    $('#selected-approver-info').slideUp();
                    $('#pending-farmers-section').slideUp();
                    
                    // ทำลาย DataTable ถ้ามี
                    if (dataTable) {
                        dataTable.destroy();
                        dataTable = null;
                    }
                }
            });

            // ค้นหาผ่าน custom search box
            $('#search-pending').on('keyup', function() {
                if (dataTable) {
                    dataTable.search($(this).val()).draw();
                }
            });
        });

        // โหลดรายการที่รอการรับรอง
        function loadPendingFarmers(verifierId) {
            $.ajax({
                url: `https://bservcpe.eng.kps.ku.ac.th/db25/db25_076/lara8Template/public/farmer-verify/pending/${verifierId}`,
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        pendingFarmersData = response.pending_farmers;
                        renderPendingFarmers(pendingFarmersData);
                        $('#pending-farmers-section').slideDown();
                    }
                },
                error: function(xhr) {
                    alert('เกิดข้อผิดพลาด: ' + xhr.responseJSON.message);
                }
            });
        }

        // แสดงรายการที่รอการรับรอง
        function renderPendingFarmers(farmers) {
            const tbody = $('#pending-farmers-list');
            
            // ทำลาย DataTable เดิมก่อน (ถ้ามี)
            if (dataTable) {
                dataTable.destroy();
                dataTable = null;
            }
            
            tbody.empty();

            if (farmers.length === 0) {
                $('#no-pending-farmers').show();
                $('#pending-farmers-table').hide();
                $('#pending-count').text('0');
                return;
            }

            $('#no-pending-farmers').hide();
            $('#pending-farmers-table').show();
            $('#pending-count').text(farmers.length);

            farmers.forEach(function(farmer, index) {
                const row = createFarmerRow(farmer, index + 1);
                tbody.append(row);
            });

            // เริ่มต้น DataTable
            initializeDataTable();
        }

        // เริ่มต้น DataTable
        function initializeDataTable() {
            dataTable = $('#pending-farmers-table').DataTable({
                "language": {
                    "lengthMenu": "แสดง _MENU_ รายการต่อหน้า",
                    "zeroRecords": "ไม่พบข้อมูล",
                    "info": "แสดงหน้า _PAGE_ จาก _PAGES_",
                    "infoEmpty": "ไม่มีข้อมูล",
                    "infoFiltered": "(กรองจากทั้งหมด _MAX_ รายการ)",
                    "search": "ค้นหา:",
                    "paginate": {
                        "first": "หน้าแรก",
                        "last": "หน้าสุดท้าย",
                        "next": "ถัดไป",
                        "previous": "ก่อนหน้า"
                    }
                },
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "ทั้งหมด"]],
                "order": [[1, 'asc']], // เรียงตามรหัสเกษตรกรโดย default
                "columnDefs": [
                    { "orderable": false, "targets": [7, 8] }, // ปิดการ sort สำหรับคอลัมน์ผู้รับรองและการดำเนินการ
                    { "type": "num", "targets": [0, 1, 4, 5] }, // กำหนดให้เป็นตัวเลข
                    { "searchable": false, "targets": [8] } // ไม่ให้ค้นหาในคอลัมน์การดำเนินการ
                ],
                "drawCallback": function() {
                    // อัพเดทลำดับหลังจาก sort หรือ paginate
                    updateTableNumbers();
                },
                "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                       '<"row"<"col-sm-12"tr>>' +
                       '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
            });
        }

        // สร้าง Row เกษตรกร
        function createFarmerRow(farmer, index) {
            const alreadyApproved = farmer.already_verified_by_this_verifier;
            const approvalCount = farmer.verifier_count;

            let statusBadge = '';
            if (alreadyApproved) {
                statusBadge = '<span class="badge text-success">รับรองแล้ว</span>';
            } else {
                statusBadge = '<span class="badge text-warning">รอการรับรอง</span>';
            }

            let approversList = '';
            if (farmer.verifier_list.length > 0) {
                approversList = farmer.verifier_list.map(function(approver) {
                    return `<small><i class="fas fa-check text-success"></i> ${approver.first_name} ${approver.last_name}</small>`;
                }).join('<br>');
            } else {
                approversList = '<small class="text-muted">ยังไม่มีผู้รับรอง</small>';
            }

            let actionButton = '';
            if (alreadyApproved) {
                actionButton = '<button class="btn btn-sm btn-secondary" disabled>รับรองแล้ว</button>';
            } else {
                actionButton = `<button class="btn btn-sm position-relative overflow-hidden" 
            onclick="approveFarmer(${farmer.farmer_id})"
            style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); 
                   color: #0369a1; 
                   padding: 4px 10px; 
                   border: 2px solid #7dd3fc;
                   border-radius: 8px;
                   font-weight: 500;
                   transition: all 0.3s ease;
                   font-size: 14px;">
            <span class="d-flex align-items-center justify-content-center gap-2">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                <span>รับรอง</span>
            </span>
        </button>`;
            }

            return `
        <tr data-farmer-id="${farmer.farmer_id}">
            <td class="text-center fw-light">${index}</td>
            <td class="text-center fw-light">${farmer.farmer_id}</td>
            <td class="text-center fw-light">${farmer.first_name} ${farmer.last_name}</td>
            <td class="text-center fw-light">${farmer.village_name}</td>
            <td class="text-center fw-light">${farmer.total_rai}</td>
            <td class="text-center fw-light">${parseFloat(farmer.pledge_right_kg).toLocaleString()}</td>
            <td class="text-center fw-light">
                ${statusBadge}<br>
                <span class="fw-light">${approvalCount}/5</span>
            </td>
            <td class="text-center fw-light">${approversList}</td>
            <td class="text-center fw-light">${actionButton}</td>
        </tr>
    `;
        }

        // รับรองเกษตรกร
        function approveFarmer(farmerId) {
            if (!confirm('คุณต้องการรับรองเกษตรกรท่านนี้ใช่หรือไม่?')) {
                return;
            }

            $.ajax({
                url: `/farmer-verify/${farmerId}/approve`,
                method: 'POST',
                data: {
                    approver_id: selectedVerifierId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);

                        // อัพเดท UI ในตาราง
                        const row = $(`tr[data-farmer-id="${farmerId}"]`);
                        const statusCell = row.find('td:eq(6)');
                        const approverCell = row.find('td:eq(7)');
                        const actionCell = row.find('td:eq(8)');

                        // อัพเดทสถานะ
                        statusCell.html(`
                    <span class="badge text-bg-success">รับรองแล้ว</span><br>
                    <span class="badge text-bg-${response.approval_count >= 5 ? 'success' : 'warning'} mt-1">${response.approval_count}/5</span>
                `);

                        // อัพเดทรายชื่อผู้รับรอง (ถ้ามีใน response)
                        if (response.verifier_list) {
                            let approversList = response.verifier_list.map(function(approver) {
                                return `<small><i class="fas fa-check text-success"></i> ${approver.first_name} ${approver.last_name}</small>`;
                            }).join('<br>');
                            approverCell.html(approversList);
                        }

                        // อัพเดทปุ่ม
                        actionCell.html(
                            '<button class="btn btn-sm btn-secondary" disabled>รับรองแล้ว</button>');

                        // ถ้าครบ 5 คน ลบแถว
                        if (response.is_verified) {
                            setTimeout(function() {
                                row.fadeOut(function() {
                                    // ลบ row ผ่าน DataTable API
                                    dataTable.row(row).remove().draw();
                                    
                                    const count = dataTable.rows().count();
                                    $('#pending-count').text(count);
                                    if (count === 0) {
                                        $('#no-pending-farmers').show();
                                        $('#pending-farmers-table').hide();
                                    }
                                });
                            }, 2000);
                        } else {
                            // โหลดข้อมูลใหม่เพื่ออัพเดทรายชื่อผู้รับรอง
                            loadPendingFarmers(selectedVerifierId);
                        }
                    }
                },
                error: function(xhr) {
                    const errorMessage = xhr.responseJSON && xhr.responseJSON.message 
                        ? xhr.responseJSON.message 
                        : 'เกิดข้อผิดพลาดในการรับรองเกษตรกร';
                    alert('เกิดข้อผิดพลาด: ' + errorMessage);
                }
            });
        }

        function updateTableNumbers() {
            if (dataTable) {
                dataTable.rows({page: 'current'}).every(function(rowIdx, tableLoop, rowLoop) {
                    const row = this.node();
                    $(row).find('td:first').text(dataTable.page.info().start + rowLoop + 1);
                });
            }
        }
    </script>
@endsection