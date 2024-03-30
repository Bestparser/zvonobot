<table class="relative border bg-white text-gray-800 w-full shadow-none text-xs text-center">
	<thead><tr><td>Сводная информация по обзвону технических специалистов, участвующих в досрочном периоде (по состоянию на @php echo date('d.m.Y'); @endphp)</td></tr></thead>
	<thead>
		<tr>
			<th class="sticky top-0 bg-white">Код</th>
			<th class="sticky top-0 bg-white">Название строк</th>
			<th class="sticky top-0 bg-white">Всего ТС</th>		
			<th class="sticky top-0 bg-white">Прошли опрос</th>	
			<th class="sticky top-0 bg-white">Нет ответа (недозвон)</th>			
			<th class="sticky top-0 bg-white">Доля (нет ответа)</th>				
			<th class="sticky top-0 bg-white">Отказались отвечать</th>
			<th class="sticky top-0 bg-white">Перезвонить позже</th>
			<th class="sticky top-0 bg-white">Ожидают звонок</th>
			<th class="sticky top-0 bg-white">Неверный номер</th>
		</tr>
	</thead>
@include('layouts.reporttoexcel_tbody')
</table>