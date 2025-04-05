@extends('mf::layouts.full')
@section('content')
<style>
.btn {
    @apply font-bold py-1 px-2 rounded;
}
.btn-blue {
    @apply bg-blue-500 text-white;
}
.btn-blue:hover {
    @apply bg-blue-700;
}
div.table-stack thead tr {
    background-color: #997e7e;
    color: #fff;
}
span[aria-current="page"] .cursor-default {
    background-color:lightgrey;
}
</style>
@include('mf::layouts.tab')
<div class="border mx-6 p-3 rounded-lg">
    <h1 class="font-bold text-3xl">
        MF請求書
    </h1>
    <div class="col-12 half table-stack">
        {{ $billings->appends(request()->input())->onEachSide(1)->links() }}
        <table class="stack w-full text-sm">
            <thead class="thead">
                <tr>
                    <th class="border text-center" colspan="3">ステータス</th>
                    <th class="border text-center">請求書番号</th>
                    <th class="border text-center">会社名</th>
                    <th class="border text-center">請求件名</th>
                    <th class="border text-center">請求日</th>
                    <th class="border text-center">販売日</th>
                    <th class="border text-center">金額</th>
                    <th class="border text-center px-3">action</th>
                </tr>
            </thead>
            <tbody class="tbody">
                @foreach($billings as $billing)
                <tr class="
                    @switch($billing->email_status)
                        @case('未送信')
                            bg-white-800
                            @break
                        @case('送付済み')
                            bg-red-200
                            @break
                        @case('受領済み')
                            bg-gray-600
                            @break
                    @endswitch
                ">
                    <td class="border border-slate-300 text-center px-1">{{ $billing->payment_status }}</td>
                    <td class="border border-slate-300 text-center px-1">{{ $billing->email_status }}</td>
                    <td class="border border-slate-300 text-center px-1">{{ $billing->posting_status }}</td>
                    <td class="border border-slate-300 text-center px-1">{{ $billing->billing_number }}</td>
                    <td class="border border-slate-300 text-center px-1">{{ $billing->partner_name }}</td>
                    <td class="border border-slate-300 text-center px-1">{{ $billing->title }}</td>
                    <td class="border border-slate-300 text-center px-1">{{ $billing->billing_date }}</td>
                    <td class="border border-slate-300 text-center px-1">{{ $billing->sales_date }}</td>
                    <td class="border border-black-800">
                        <div class="grid grid-cols-2 px-3">
                            <div class="grid-item border-b-1 font-bold">請求金額</div>
                            <div class="grid-item border-b-1 text-right">{{ yen($billing->subtotal_price) }}</div>
                        </div>
                        <div class="grid grid-cols-2 px-3">
                            <div class="grid-item border-b-1 font-bold">消費税額</div>
                            <div class="grid-item border-b-1 text-right">{{ yen($billing->excise_price_of_ten_percent) }}</div>
                        </div>
                        <div class="grid grid-cols-2 px-3">
                            <div class="grid-item font-bold">合計金額</div>
                            <div class="grid-item text-right">{{ yen($billing->total_price) }}</div>
                        </div>
                    </td>
                    <td class="border border-slate-300 text-center px-3">
                        <a href="quotation/download?path={{ $billing->pdf_url }}&filename={{ $billing->billing_number.'('.$billing->title.')' }}" class="btn bg-blue-400 hover:bg-blue-600 text-white py-1 px-2 rounded">download</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection