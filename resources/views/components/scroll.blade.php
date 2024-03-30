<table class="m-2 w-full shadow-none text-left">
	<tbody>
		<tr class="">
			<td class="w-2/4 text-left">
			@empty (!$all)
					<div class="w-full text-left">Всего записей: <span class="text-xl text-blue-800">{{ $all }}</span></div>
			@endempty
			</td>
			<td class="p-2 text-right w-1/4">
			
			
@empty (!$prev)	
<div class="flex justify-end items-end">
			<a href="{{route( $view, ['page' => $prev, 'filter' => (request()->has('filter')) ? request()->get('filter') : null])}}">
				<button type="button" class="flex justify-end focus:outline-none text-blue-800 text-sm py-1.5 px-2.5 rounded-md border border-blue-800 hover:bg-blue-50">
					<svg class="h-5 w-6 text-blue-800  mr-2"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
					  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
					</svg>
					<div>предыдущая страница</div>     
				</button>
			</a>
</div>			
@endempty
		</td>
		<td class="p-2 text-right w-1/4">
@empty (!$next)
<div class="flex justify-end items-end mr-4">
			<a href="{{route( $view, ['page' => $next, 'filter' => (request()->has('filter')) ? request()->get('filter') : null])}}">
				<button type="button" class="flex focus:outline-none text-blue-800 text-sm py-1.5 px-2.5 rounded-md border border-blue-800 hover:bg-blue-50">
					<div>следующая страница</div> 
					<svg class="h-5 w-6 text-blue-800 ml-2"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
					  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
					</svg>	   
				</button>
			</a>
</div>			
@endempty		
			
			
			</td>
		</tr>
	</tbody>
</table>
{{ $slot }}
