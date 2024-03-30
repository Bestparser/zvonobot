@props(['errors'])

@if ($errors->any())
	<div class="bg-red-50 mt-5 mx-4 py-3 px-9 rounded-xl">
		<div class="text-xl uppercase text-red-600">
			Ошибка!
		</div>

		<ul class="mt-3 list-disc list-inside text-sm text-red-600">
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif