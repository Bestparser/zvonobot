<table class="relative border bg-white text-gray-800 w-full shadow-none text-xs text-center">
	<thead>
		<tr>
			<th class="sticky top-0 bg-white">Телефон</th>
			<th class="sticky top-0 bg-white">Регион</th>
			<th class="sticky top-0 bg-white">Часовой пояс</th>
			<th class="sticky top-0 bg-white">Статус</th>
		</tr>
	</thead>
    <tbody class="divide-y">
        @foreach ($calls as $i)
            @if ($i->mobile)
                <tr>
                    <td class="">{{ $i->mobile }}</td>
                    <td class="">{{ $i->RegionName }}</td>
                    <td class="">{{ $i->timezone }}</td>
                    <td class="">{{ $i->status }}</td>
                </tr>
            @endif
        @endforeach
    </tbody>    
</table>