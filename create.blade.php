{{-- เพิ่มข้อมูล --}}
@extends('layouts.farmer.')

@section('title', 'เพิ่มข้อมูลเกษตรกร')
@section('page-title', 'เพิ่มข้อมูลเกษตรกร')
@section('role-name', 'เกษตรกร')

@section('sidebar-menu')
<!-- ใช้เมนูเดียวกับ index.blade.php -->
<li>
    {{-- <a href="{{ route('farmer.dashboard') }}" class="menu-item">
        <span class="icon">🏠</span>
        หน้าหลัก
    </a> --}}
    <a href="{{ route('farmer.dashboard') }}" class="menu-item">
        <span class="icon">🏠</span>
        หน้าหลัก
    </a>
</li>
<li>
    {{-- <a href="{{ route('farmer.profile.index') }}" class="menu-item active">
        <span class="icon">👤</span>
        ข้อมูลเกษตรกร
    </a> --}}
    <a href="{{ route('farmer.profile.index') }}" class="menu-item active">
        <span class="icon">👤</span>
        ข้อมูลเกษตรกร
    </a>
</li>
<li>
    {{-- <a href="{{ route('farmer.guarantor.index') }}" class="menu-item">
        <span class="icon">👥</span>
        ผู้ค้ำประกัน
    </a> --}}
    <a href="{{ route('farmer.guarantor.index') }}" class="menu-item">
        <span class="icon">👥</span>
        ผู้ค้ำประกัน
    </a>
</li>
<li>
    {{-- <a href="{{ route('farmer.pledge.index') }}" class="menu-item">
        <span class="icon">📋</span>
        การจำนำข้าว
    </a> --}}
    <a href="{{ route('farmer.pledge.index') }}" class="menu-item">
        <span class="icon">📋</span>
        การจำนำข้าว
    </a>
</li>
<li>
    {{-- <a href="{{ route('farmer.report') }}" class="menu-item">
        <span class="icon">📊</span>
        รายงาน
    </a> --}}
    <a href="{{ route('farmer.report') }}" class="menu-item">
        <span class="icon">📊</span>
        รายงาน
    </a>
</li>
@endsection

@section('styles')
<style>
    .form-container {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        max-width: 800px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #374151;
    }

    input, select, textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s;
    }

    input:focus, select:focus, textarea:focus {
        outline: none;
        border-color: #059669;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .btn-group {
        display: flex;
        gap: 12px;
        margin-top: 30px;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s;
    }

    .btn-primary {
        background: #059669;
        color: white;
    }

    .btn-primary:hover {
        background: #047857;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .menu-item {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        border-radius: 8px;
        color: #4b5563;
        text-decoration: none;
        transition: all 0.3s;
    }

    .menu-item:hover {
        background: #f3f4f6;
        color: #059669;
    }

    .menu-item.active {
        background: #d1fae5;
        color: #059669;
        font-weight: 600;
    }

    .menu-item .icon {
        margin-right: 12px;
        font-size: 1.2rem;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="form-container">
    <form action="{{ route('farmer.profile.store') }}" method="POST">
        @csrf
        
        <div class="form-row">
            <div class="form-group">
                <label>ชื่อ <span style="color: red;">*</span></label>
                <input type="text" name="first_name" required>
            </div>
            <div class="form-group">
                <label>นามสกุล <span style="color: red;">*</span></label>
                <input type="text" name="last_name" required>
            </div>
        </div>

        <div class="form-group">
            <label>เลขบัตรประชาชน <span style="color: red;">*</span></label>
            <input type="text" name="id_card" pattern="[0-9]{13}" placeholder="1234567890123" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>เบอร์โทรศัพท์ <span style="color: red;">*</span></label>
                <input type="tel" name="phone" pattern="[0-9]{10}" placeholder="0812345678" required>
            </div>
            <div class="form-group">
                <label>อีเมล</label>
                <input type="email" name="email" placeholder="example@email.com">
            </div>
        </div>

        <div class="form-group">
            <label>ที่อยู่ <span style="color: red;">*</span></label>
            <textarea name="address" rows="3" required></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>จำนวนไร่ <span style="color: red;">*</span></label>
                <input type="number" name="rai" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label>สิทธิ์จำนำ (กก.) <span style="color: red;">*</span></label>
                <input type="number" name="pledge_limit" step="0.01" min="0" required>
            </div>
        </div>

        <h3 style="margin-top: 30px; margin-bottom: 15px;">ข้อมูลบัญชีธนาคาร</h3>
        
        <div class="form-row">
            <div class="form-group">
                <label>ธนาคาร <span style="color: red;">*</span></label>
                <select name="bank_name" required>
                    <option value="">เลือกธนาคาร</option>
                    <option value="กรุงเทพ">ธนาคารกรุงเทพ</option>
                    <option value="กสิกรไทย">ธนาคารกสิกรไทย</option>
                    <option value="ไทยพาณิชย์">ธนาคารไทยพาณิชย์</option>
                    <option value="กรุงไทย">ธนาคารกรุงไทย</option>
                </select>
            </div>
            <div class="form-group">
                <label>เลขที่บัญชี <span style="color: red;">*</span></label>
                <input type="text" name="account_number" pattern="[0-9]{10}" placeholder="1234567890" required>
            </div>
        </div>

        <div class="form-group">
            <label>ชื่อบัญชี <span style="color: red;">*</span></label>
            <input type="text" name="account_name" required>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-primary">💾 บันทึก</button>
            <a href="{{ route('farmer.profile.index') }}" class="btn btn-secondary">❌ ยกเลิก</a>
        </div>
    </form>
</div>
@endsection