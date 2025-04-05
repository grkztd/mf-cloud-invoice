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
        MF取引先
    </h1>
    <div class="col-12 half table-stack">
        {{ $partners->appends(request()->input())->onEachSide(1)->links() }}
        <table class="stack w-full text-sm bg-white">
            <thead class="thead">
                <tr>
                    <th class="border text-center">コード</th>
                    <th class="border text-center">会社名</th>
                    <th class="border text-center">会社名（カナ）</th>
                    <th class="border text-center">作成日</th>
                </tr>
            </thead>
            <tbody class="tbody">
                @foreach($partners as $partner)
                <tr class="">
                    <td class="border border-slate-300 text-center px-3">{{ $partner->code }}</td>
                    <td class="border border-slate-300 text-center px-3">{{ $partner->name }}</td>
                    <td class="border border-slate-300 text-center px-3">{{ $partner->name_kana }}</td>
                    <td class="border border-slate-300 text-center px-3">{{ $partner->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection