<div class="m-1 w-full flex text-xs">
	<dd class="text-xs px-1 item whitespace-nowrap align-baseline mt-0.5">
		Записей: <span class="text-sm font-bold"> {{ $rows_real }}</span> из <span class="text-sm font-bold"> {{ $rows_all }}</span>
	</dd>
	<dd class="px-1 item">
		<button onclick="pagepref();" type="button" class="h-5 px-0 bg-indigo-500 rounded text-white hover:bg-indigo-400">
			<svg class="h-3 w-5 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <polyline points="11 17 6 12 11 7" />  <polyline points="18 17 13 12 18 7" /></svg>            </dd>
	<dd class="px-1 item">
		<select id="pageselect" name="pageselect" class="h-5 w-12 m-0 p-0.5 text-xs bg-transparent border-blue-800 item">
		</select>
	</dd>
	<dd class="px-1 item">
		<button onclick="pagenext();" type="button" class="h-5 px-0 bg-indigo-500 rounded text-white hover:bg-indigo-400">
			<svg class="h-3 w-5 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <polyline points="13 17 18 12 13 7" />  <polyline points="6 17 11 12 6 7" /></svg>
        </button>
	</dd>

	<dd class="px-1 item text-center  flex-auto">{{ config('app.name') }}, {{ config('app.ver') }} U{{ Auth::user()->UserID }} <span id="online"></span></dd>

	<dd class="px-1 item">
        <div class="text-right">
            @if (Auth::user()->RoleID==1)
            <a href="{{ URL::route('export') }}">
                <button type="button" class="h-5 px-2 bg-indigo-500 rounded text-white hover:bg-indigo-400">
                    Экспорт в Excel
                </button>
            </a>
            @endif
	    </div>
	</dd>
</div>
