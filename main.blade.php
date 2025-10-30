{{-- resources/views/dashboard.blade.php --}}
@extends('layout.myLayout')

@section('title', 'แดชบอร์ด')
@section('page_title', 'แดชบอร์ด')

@section('content')
@php
  // สีของ badge สถานะ
  $statusBadge = [
    'Active'      => 'primary',
    'Redeemed'    => 'success',
    'Transferred' => 'warning',
    'Expired'     => 'secondary',
    'Cancelled'   => 'danger',
    'Defaulted'   => 'secondary',
  ];

  // รวมจำนวน และฟังก์ชันฟอร์แมตตัวเลข
  $total  = method_exists($pawnings, 'total') ? $pawnings->total() : $pawnings->count();
  $fmtNum = fn($v, $d = 2) => is_numeric($v) ? number_format($v, $d) : '—';

  // ทำให้ความสูงคงที่เหมือนหน้าเต็ม 10 แถว
  $perPage   = method_exists($pawnings, 'perPage') ? $pawnings->perPage() : 10;
  $curCount  = $pawnings instanceof \Illuminate\Pagination\LengthAwarePaginator ? $pawnings->count() : count($pawnings);
  $ghostRows = max($perPage - $curCount, 0);
  $colspan   = 11; // จำนวนคอลัมน์ทั้งหมด
@endphp

<style>
  .text-num { text-align:right; font-variant-numeric: tabular-nums; }
  .sticky-head th { position: sticky; top: 0; z-index: 5; }
  .table-scroll { max-height: 60vh; overflow: auto; }  /* เลื่อนถ้าล้น (แนว x/y) */
  .ghost-row td { color: transparent; pointer-events: none; }
  .table td, .table th { padding-top: .6rem; padding-bottom: .6rem; }
</style>

<div class="card shadow-sm border-0">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <h6 class="mb-0">รายการจำนำข้าว</h6>
    <span class="badge text-bg-secondary">รวม {{ $total }} รายการ</span>
  </div>

  <div class="table-responsive table-scroll">
    <table class="table table-sm table-hover align-middle text-nowrap mb-0">
      <thead class="table-light sticky-head">
        <tr class="text-center">
          <th >id</th>
          <th >farmer_name</th>
          <th >rice_name</th>
          <th >deposit_date</th>
          <th >end_date</th>
          <th >warehouse_name</th>
          <th >weight</th>
          <th >humidity</th>
          <th >mixed</th>
          <th >status_name</th>
          <th >money_withdraw_date</th>
           <th >จัดการ</th>
        </tr>
      </thead>

      <tbody>
        @forelse ($pawnings as $p)
          <tr>
            {{-- แสดงเลขลำดับ ต่อเนื่องตามหน้า หาก paginate; ถ้าไม่ paginate จะเริ่มที่ 1 --}}
            <td class="text-num text-center">
              {{ (method_exists($pawnings, 'firstItem') && $pawnings->firstItem())
                    ? $pawnings->firstItem() + $loop->index
                    : $loop->iteration }}
            </td>

            <td class="fw-medium" style="text-align:left;">{{ $p->farmer_name ?? '—' }}</td>
            <td class="text-center">{{ $p->rice_name ?? '—' }}</td>
            <td class="text-center">{{ $p->deposit_date ?? '—' }}</td>
            <td class="text-center">{{ $p->end_date ?? '—' }}</td>
            <td class="text-center">{{ $p->warehouse_name ?? '—' }}</td>
            <td class="text-num text-center">{{ $fmtNum($p->weight, 2) }}</td>
            <td class="text-num text-center">{{ $fmtNum($p->humidity, 1) }}</td>
            <td class="text-num text-center">{{ $fmtNum($p->mixed, 2) }}</td>
            <td class="text-center">
              @php $badge = $statusBadge[$p->status_name ?? ''] ?? 'secondary'; @endphp
              <span class="badge text-bg-{{ $badge }}">{{ $p->status_name ?? '—' }}</span>
            </td>
            <td class="text-center">{{ $p->money_withdraw_date ?? '—' }}</td>
             <td class="text-center">{{  }}</td>
          </tr>
        @empty
          <tr><td colspan="{{ $colspan }}" class="text-center py-4">ไม่มีข้อมูล</td></tr>
        @endforelse

        {{-- เติมแถวว่างให้ครบจำนวนต่อหน้า เพื่อความสูงเท่าเดิม --}}
        @for ($i = 0; $i < $ghostRows; $i++)
          <tr class="ghost-row">
            @for ($c = 0; $c < $colspan; $c++)
              <td>&nbsp;</td>
            @endfor
          </tr>
        @endfor
      </tbody>
    </table>
  </div>

  @if (method_exists($pawnings, 'links'))
    <div class="card-footer bg-white">
      {{ $pawnings->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>
  @endif
</div>
@endsection
