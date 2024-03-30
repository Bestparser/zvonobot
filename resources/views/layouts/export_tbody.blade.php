<tbody class="divide-y">
    @php $r = 1; @endphp
    @forelse ($calls as $i)
        <tr id="tr{{$i->UID}}" data-id="{{$i->UID}}" class="whitespace-nowrap callstr {{ ($r % 2 == 0 ? '' : 'bg-gray-50') }}">
            @include('layouts.export_tr')
        </tr>
    @empty
        <tr><td colspan="16" class="border border-blue-200 px-2 py-10 text-center text-red-500">нет данных</td></tr>
        @php $r++;  @endphp
    @endforelse
</tbody>
