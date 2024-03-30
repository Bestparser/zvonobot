<tbody class="divide-y">
@forelse ($calls as $i)

@include('layouts.calltr');

	@empty
		<tr><td colspan="16" class="border border-blue-200 px-2 py-10 text-center text-red-500">нет данных</td></tr>
	@endforelse
</tbody>
