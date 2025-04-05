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
        MF見積書
    </h1>
    <div class="col-12 half table-stack">
        {{ $quotations->appends(request()->input())->onEachSide(1)->links() }}
        <table class="stack w-full text-sm">
            <thead class="thead">
                <tr>
                    <th class="border text-center">ステータス</th>
                    <th class="border text-center">見積り番号</th>
                    <th class="border text-center">会社名</th>
                    <th class="border text-center">見積り件名</th>
                    <th class="border text-center">見積り日</th>
                    <th class="border text-center">見積締切</th>
                    <th class="border text-center">金額</th>
                    <th class="border text-center px-3">action</th>
                </tr>
            </thead>
            <tbody class="tbody">
                @foreach($quotations as $quotation)
                <tr class="
                    @switch($quotation->order_status)
                        @case('default')
                            bg-white-800
                            @break
                        @case('received')
                            bg-blue-200
                            @break
                        @case('not_received')
                            bg-red-200
                            @break
                        @case('failure')
                            bg-gray-600
                            @break
                    @endswitch
                ">
                    <td class="border border-slate-300 text-center px-3">{{ $statuses[$quotation->order_status] }}</td>
                    <td class="border border-slate-300 text-center px-3">{{ $quotation->quote_number }}</td>
                    <td class="border border-slate-300 text-center px-3">{{ $quotation->partner_name }}</td>
                    <td class="border border-slate-300 text-center px-3">{{ $quotation->title }}</td>
                    <td class="border border-slate-300 text-center px-3">{{ $quotation->quote_date }}</td>
                    <td class="border border-slate-300 text-center px-3">{{ $quotation->expired_date }}</td>
                    <td class="border border-black-800">
                        <div class="grid grid-cols-2 px-3">
                            <div class="grid-item border-b-1 font-bold">見積り金額</div>
                            <div class="grid-item border-b-1 text-right">{{ yen($quotation->subtotal_price) }}</div>
                        </div>
                        <div class="grid grid-cols-2 px-3">
                            <div class="grid-item border-b-1 font-bold">消費税額</div>
                            <div class="grid-item border-b-1 text-right">{{ yen($quotation->excise_price_of_ten_percent) }}</div>
                        </div>
                        <div class="grid grid-cols-2 px-3">
                            <div class="grid-item font-bold">合計金額</div>
                            <div class="grid-item text-right">{{ yen($quotation->total_price) }}</div>
                        </div>
                    </td>
                    <td class="border border-slate-300 text-center">
                        <a href="quotation/download?path={{ $quotation->pdf_url }}&filename={{ $quotation->quote_number.'('.$quotation->title.')' }}" class="btn bg-blue-400 hover:bg-blue-600 text-white py-1 px-2 rounded">download</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection