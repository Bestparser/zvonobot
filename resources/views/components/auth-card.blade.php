<div style="background: url({{ asset('img/bg_body2.jpg') }}) no-repeat top center;background-size:cover;" class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-0 px-4 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
	
	<div class="h-32">
        
    </div>
</div>
