<dd class="text-xl text-blue-800 text-right">
  <div>{{ Session::get('StationName') }} ({{ Session::get('RegionName') }})
  @if ( count(Auth::user()->getAuditoriums())==1 )	
		&mdash; {{ Auth::user()->getAuditorium()->AuditoriumCode }} ({{ Auth::user()->getAuditorium()->AuditoriumName }})
  @endif
  </div>
</dd>