<tbody class="divide-y">
    <!-- Итог -->
    <tr>
        <td class="text-left"></td>
        <td class="text-left">Общий итог</td>
        <td class="text-left">{{ $arrTotalTable['vse_ts'] }}</td> <!-- Всего ТС --> 
        <td class="text-left">{{ $arrTotalTable['arrTotalTableCommunication'][3] }}</td> <!-- Прошли опрос -->        
        <td class="text-left">{{ $arrTotalTable['arrTotalTableCommunication'][1] }}</td> <!-- Нет ответа -->        
        <td class="text-left">{{ $arrTotalTable['totalTablePercent'] }} %</td> <!-- Доля, нет ответа -->        
        <td class="text-left">{{ $arrTotalTable['arrTotalTableCommunication'][2] }}</td> <!-- Отказались отвечать -->
        <td class="text-left">{{ $arrTotalTable['arrTotalTableCommunication'][4] }}</td> <!-- Перезвонить позже (некогда говорить) -->
        <td class="text-left">{{ $arrTotalTable['arrTotalTableCommunication'][5] }}</td> <!-- Ожидают звонок -->
        <td class="text-left">{{ $arrTotalTable['arrTotalTableCommunication'][0] }}</td> <!-- Неверный номер -->        
    </tr>
    <!-- end Итог -->

    @php $r = 1; @endphp
    @forelse ($calls as $i)
        <tr class="whitespace-nowrap callstr {{ ($r % 2 == 0 ? '' : 'bg-gray-50') }}">
            @include('layouts.reporttoexcel_tr')
        </tr>
    @empty
        <tr><td colspan="16" class="border border-blue-200 px-2 py-10 text-center text-red-500">нет данных</td></tr>
        @php $r++;  @endphp
    @endforelse
</tbody>



