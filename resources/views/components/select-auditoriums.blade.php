@if (count(Auth::user()->getAuditoriums())>1)							
                              <select value="aud" name="aud" class="bg-transparent">
                                <option value="0">-</option>				
                                    @foreach (Auth::user()->getAuditoriums() as $aud)
                                    <?php
                                      if ($aud->AuditoriumID == request()->get('aud')) {
                                          $selected = ' selected';
                                      } else {
                                            $selected = '';
                                      }
                                    ?>
                                      <option value="{{ $aud->AuditoriumID }}"{{ $selected }}>
									  {{ $aud->AuditoriumCode }} ({{ $aud->AuditoriumName }})</option>
                                    @endforeach
							</select>
@elseif ( count(Auth::user()->getAuditoriums())==1 )	
							{{ Auth::user()->getAuditorium()->AuditoriumCode }} ({{ Auth::user()->getAuditorium()->AuditoriumName }})
						<input type="hidden" name="aud" value="{{ Auth::user()->getAuditorium()->AuditoriumID }}">
@else
		<div class="text-red-700 font-bold">не выбрана аудитория</div>
@endif	