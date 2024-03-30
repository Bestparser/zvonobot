<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Ошибка 405.{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="{{ asset('css/font_local.css') }}">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
         <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                  <a href="{{route('call')}}">
                    <img src="{{ asset('img/fct_logo_m.png') }}" alt="" class="block h-10 w-auto fill-current text-gray-600">
                  </a>
                </div>
            </div>
        </div>
    </div>
</nav>

            <!-- Page Content -->
            <main>
                <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h2 class="font-semibold text-2xl text-blue-800 leading-tight">
                        Ошибка
                    </h2>

<div class="flex items-center">
<div class="my-24 mx-auto text-center">

<table class="table-auto">
  <tbody>
    <tr>
      <td>
     <svg class="mx-5 flex-shrink-0 object-cover object-center h-10 w-10 text-red-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />  <line x1="12" y1="9" x2="12" y2="13" />  <line x1="12" y1="17" x2="12.01" y2="17" /></svg>
	</td>
	<td class="text-xl">Обновите страницу и повторите действие</td>
    </tr>
  </tbody>
</table>

</div>
</div>


                </div>
            </div>
        </div>
    </div>
                <div class="text-center max-w-7xl mx-auto sm:px-6 lg:px-8">
                  <div class="text-sm font-medium leading-5 text-gray-900 transition duration-150 ease-in-out rounded-lg p-2 shadow bg-white">
                    {{ config('app.name') }}
                  </div>
                </div>
                <br><br><br>
            </main>
        </div>

    </body>
</html>

