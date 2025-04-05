<div class="mx-10 mt-5">
    <ul class="flex border-b" style="border:none">
        <li class="text-slate-600 rounded-t-lg border cursor-pointer py-2 px-4 {{ basename(url()->current()) === 'quotations' ? 'font-bold bg-violet-200' : 'bg-violet-100' }}">
            <a href="quotations" class="btn tab-label">見積書</a>
        </li>
        <li class="text-slate-600 rounded-t-lg border cursor-pointer py-2 px-4 {{ basename(url()->current()) === 'billings' ? 'font-bold bg-violet-200' : 'bg-violet-100' }}">
            <a href="billings" class="btn tab-label">請求書</a>
        </li>
        <li class="text-slate-600 rounded-t-lg border cursor-pointer py-2 px-4 {{ basename(url()->current()) === 'partners' ? 'font-bold bg-violet-200' : 'bg-violet-100' }}">
            <a href="partners" class="btn tab-label">取引先</a>
        </li>
    </ul>
</div>