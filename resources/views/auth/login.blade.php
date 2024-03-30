<x-guest-layout>
    <x-auth-card>
	    <h2 class="mb-6 text-center font-semibold text-xl text-blue-900 leading-tight">

        </h2>


<x-slot name="logo">
    <svg class="m-10 h-24 w-24 text-blue-800"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M15.05 5A5 5 0 0 1 19 8.95M15.05 1A9 9 0 0 1 23 8.94m-1 7.98v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" /></svg>
</x-slot>


        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="bg-red-50 mb-4 p-4 rounded-xl" :errors="$errors" />
<div class="px-2">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Имя пользователя:')" />

                <x-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Пароль:')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>


            <div class="flex items-center justify-end mt-4" style="position: relative;">
                <select name="anketaID" id="thooseAnket">                    
                    @foreach($ankets as $anketa)
                        @if ($anketa->hidden == 0)
                            <option value="{{$anketa->id}}">{{$anketa->a_name}}</option>
                        @endif
                    @endforeach
                </select>
                <!--@if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif-->

                <x-button class="ml-3 bg-blue-900">
                    {{ __('Вход') }}
                </x-button>
            </div>
        </form>
		</div>
    </x-auth-card>
</x-guest-layout>
