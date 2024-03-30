 <table class="relative border bg-white text-gray-800 w-full shadow-none text-xs text-center">
                        <thead>
                            <tr class="">
                                <th class="sticky top-0 bg-blue-50">
                                    <a onclick="orderRegion();" href="#" class="flex w-full justify-center">
                                        <div class="items">Регион</div>
                                        <div class="items ml-1 mt-1">
                                            @if (request()->has('order'))
                                                @if (request()->get('order')==3)
                                                <svg version="1.1"  width="10px" height="10px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xml:space="preserve" viewBox="0 0 100 100" preserveAspectRatio="none" >
                                                    <polygon fill="rgb(30 64 175)" points="0,100 50,0 100,100"/>
                                                    </svg>
                                                @endif
                                                @if (request()->get('order')==4)
                                                <svg version="1.1"  width="10px" height="10px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xml:space="preserve" viewBox="0 0 100 100" preserveAspectRatio="none" >
                                                    <polygon fill="rgb(30 64 175)" points="0,0 50,100 100,0"/>
                                                    </svg>
                                                @endif
                                            @endif
                                        </div>
                                    </a>
                                </th>
                                <th class="sticky top-0 bg-blue-50">ППЭ</th>
                                <!--<th class="sticky top-0 bg-blue-50">Должность</th>-->
                                <th class="sticky top-0 bg-blue-50">
                                    <a onclick="orderFIO();" href="#" class="flex w-full justify-center">
                                        <div class="items">ФИО</div>
                                        <div class="items ml-1 mt-1">
                                            @if (request()->has('order'))
                                                @if (request()->get('order')==1)
                                                <svg version="1.1"  width="10px" height="10px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xml:space="preserve" viewBox="0 0 100 100" preserveAspectRatio="none" >
                                                    <polygon fill="rgb(30 64 175)" points="0,100 50,0 100,100"/>
                                                    </svg>
                                                @endif
                                                @if (request()->get('order')==2)
                                                <svg version="1.1"  width="10px" height="10px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xml:space="preserve" viewBox="0 0 100 100" preserveAspectRatio="none" >
                                                <polygon fill="rgb(30 64 175)" points="0,0 50,100 100,0"/>
                                                    </svg>
                                                @endif
                                            @endif
                                        </div>
                                    </a>
                                </th>
                                <th class="sticky top-0 bg-blue-50">Телефон</th>
                                <th class="sticky top-0 bg-blue-50">Удалось связаться с пользователем?</th>
                                <th class="sticky top-0 bg-blue-50">Пользователь является техническим специалистом пункта?</th>
                                <th class="sticky top-0 bg-blue-50">Оценка</th>
                                <th class="sticky top-0 bg-blue-50">Оператор</th>
                                <th class="sticky top-0 bg-blue-50">
                                    <a onclick="orderDate();" href="#" class="flex w-full justify-center">
                                        <div class="items">Дата и время</div>
                                        <div class="items ml-1 mt-1">
                                            @if (request()->has('order'))
                                                @if (request()->get('order')==5)
                                                <svg version="1.1"  width="10px" height="10px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xml:space="preserve" viewBox="0 0 100 100" preserveAspectRatio="none" >
                                                    <polygon fill="rgb(30 64 175)" points="0,100 50,0 100,100"/>
                                                    </svg>
                                                @endif
                                                @if (request()->get('order')==6)
                                                <svg version="1.1"  width="10px" height="10px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xml:space="preserve" viewBox="0 0 100 100" preserveAspectRatio="none" >
                                                    <polygon fill="rgb(30 64 175)" points="0,0 50,100 100,0"/>
                                                    </svg>
                                                @endif
                                            @endif
                                        </div>
                                    </a>
                                </th>
                                @if ($role != 2)<th class="sticky top-0 bg-blue-50">Удалить</th> @endif
                            </tr>
                        </thead>
                        @include('layouts.call_tbody')
                </table>
