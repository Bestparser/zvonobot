<table class="relative border bg-white text-gray-800 w-full shadow-none text-xs text-center">
	<thead>
		<tr>
			<th class="sticky top-0 bg-white">Регион</th>
			<th class="sticky top-0 bg-white">Должность</th>
			<th class="sticky top-0 bg-white">ФИО</th>
			<th class="sticky top-0 bg-white">Телефон</th>

			@foreach ($questions as $question)
				<th class="sticky top-0 bg-white">{{ $question->q_name }}</th>
			@endforeach

			<th class="sticky top-0 bg-white">Оператор</th>
			<th class="sticky top-0 bg-white">Дата и время</th>
		</tr>
	</thead>
@include('layouts.export_tbody')
</table>