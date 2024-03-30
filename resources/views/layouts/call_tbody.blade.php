<tbody class="divide-y">
        @php $r = 1; @endphp
    @forelse ($calls as $i)
        <tr id="tr{{$i->UID}}" data-id="{{$i->UID}}" class="whitespace-nowrap callstr {{ ($r % 2 == 0 ? '' : 'bg-gray-50') }}">
            @include('layouts.call_tr')
            @if ($role != 2) <td class="{{ $i-> bg }}"><a class="deleteTS" onclick="return sureDeleteTS();" href="{{ route('layouts.deletets') }}?uid={{ $i->UID}}">Удалить</a></td> @endif
        </tr>
        @php $r = $r+1;  @endphp
    @empty
        <tr><td colspan="15" class="border border-blue-200 px-2 py-10 text-center text-red-500">нет данных</td></tr>
    @endforelse
</tbody>
