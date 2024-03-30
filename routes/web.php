<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// ------------------------------------- Страница "Обзвон" -------------------------------------
// Вывод страницы
Route::get('/', [App\Http\Controllers\CallController::class, 'call'])
                ->middleware('auth')
                ->name('home');

// Вывод страницы
Route::get('/call', [App\Http\Controllers\CallController::class, 'call'])
                                ->middleware('auth')
                                ->name('call');

// Сохранение отредактированной карточки
Route::post('/CallSave', [App\Http\Controllers\CallController::class, 'CallSave'])
                                ->middleware('auth')
                                ->name('CallSave');

// Форма редактирования карточки
Route::post('/CallEdit', [App\Http\Controllers\CallController::class, 'CallEdit'])
                                ->middleware('auth')
                                ->name('CallEdit');

// Export в Excel 
Route::get('/export', [App\Http\Controllers\CallController::class, 'exportToExcel'])
                                ->middleware('auth', 'role')
                                ->name('export');

// Удалить ТС (воркера)                                
Route::get('/deleteTS', [App\Http\Controllers\CallController::class, 'deleteTS'])
                                ->middleware('auth', 'role')
                                ->name('layouts.deletets');


// ------------------------------------- end Страница "Обзвон" -------------------------------------






// ------------------------------------- Страница "Отчеты" -------------------------------------
// Вывод страницы
Route::get('/report', [App\Http\Controllers\ReportController::class, 'report'])
                                ->middleware('auth', 'role')
                                ->name('report');

// Результаты обзвона ТС
Route::get('/reporttoexcel', [App\Http\Controllers\ReportController::class, 'reportToExcel'])
                                ->middleware('auth', 'role')
                                ->name('reporttoexcel');

// ------------------------------------- end Страница "Отчеты" -------------------------------------







// ------------------------------------- Страница "Загрузить из ФИС" --------------------------------
// Вывод страницы
Route::get('/importLog', [App\Http\Controllers\ImportController::class, 'importLog'])
                                ->middleware('auth', 'role')
                                ->name('importLog');

// Загрузить данные из ФИС
Route::post('/importExcel', [App\Http\Controllers\ImportController::class, 'importExcel'])
                                ->middleware('auth', 'role')
                                ->name('importexcel');

// ------------------------------------- end Страница "Загрузить из ФИС" --------------------------------







// ------------------------------------- Страница "Выгрузить в мониторинг" --------------------------------
// Вывод страницы
Route::get('/exportLog', [App\Http\Controllers\ExportController::class, 'exportLog'])
                                ->middleware('auth', 'role')
                                ->name('exportLog');

// Старт экспорта в мониторинг
Route::get('/exportcsv', [App\Http\Controllers\ExportController::class, 'exportToCSV'])
                                ->middleware('auth', 'role')
                                ->name('exportcsv');

// ------------------------------------- end Страница "Выгрузить в мониторинг" --------------------------------






// ------------------------------------- Страница "Пользователи" --------------------------------
// Вывод страницы
Route::get('/users', [App\Http\Controllers\UsersController::class, 'users'])
                                ->middleware('auth', 'role')
                                ->name('users');

// Сохранение добавления нового пользователя
Route::post('/useraddsave', [App\Http\Controllers\UsersController::class, 'userAddSave'])
                                ->middleware('auth', 'role')
                                ->name('users.useraddsave');

// Сохранние отредактированного пользователя
Route::post('/usereditsave', [App\Http\Controllers\UsersController::class, 'userEditSave'])
                                ->middleware('auth', 'role')
                                ->name('users.usereditsave');

// Удаление пользователя
Route::post('/userdelete', [App\Http\Controllers\UsersController::class, 'userDelete'])
                                ->middleware('auth', 'role')
                                ->name('users.userdelete');

// ------------------------------------- end Страница "Пользователи" --------------------------------






// ------------------------------------- Страница "Анкеты" -------------------------------------
// Анкеты. Вывод страницы
Route::get('/ankets', [App\Http\Controllers\AnketsController::class, 'routerAnkets']) // Список анкет
                                ->middleware('auth', 'role')
                                ->name('ankets');
Route::post('/addsave', [App\Http\Controllers\AnketsController::class, 'anketaAddSave']) // Сохранение новой анкеты
                                ->middleware('auth', 'role')
                                ->name('ankets.addsave');
Route::post('/editsave', [App\Http\Controllers\AnketsController::class, 'anketaEditSave']) // Сохранение отредактированной анкеты
                                ->middleware('auth', 'role')
                                ->name('ankets.editsave');
Route::post('/anketadelete', [App\Http\Controllers\AnketsController::class, 'anketaDelete']) // Удаление анкеты
                                ->middleware('auth', 'role')
                                ->name('layouts.ankets.anket_delete');
                                

// Вопросы
Route::post('/questionaddsave', [App\Http\Controllers\AnketsController::class, 'questionAddSave']) // Сохранение нового вопроса
                                ->middleware('auth', 'role')
                                ->name('ankets.questionaddsave');
Route::post('/questioneditsave', [App\Http\Controllers\AnketsController::class, 'questionEditSave']) // Сохранение отредактированного вопроса
                                ->middleware('auth', 'role')
                                ->name('ankets.questioneditsave');
Route::post('/questiondelete', [App\Http\Controllers\AnketsController::class, 'questionDelete']) // Удаление вопроса
                                ->middleware('auth', 'role')
                                ->name('layouts.ankets.question_delete');


// Ответы                                
Route::post('/answeraddsave', [App\Http\Controllers\AnketsController::class, 'answerAddSave']) // Сохранение нового ответа
                                ->middleware('auth', 'role')
                                ->name('ankets.answeraddsave');
Route::post('/answereditsave', [App\Http\Controllers\AnketsController::class, 'answerEditSave']) // Сохранение отредактированного ответа
                                ->middleware('auth', 'role')
                                ->name('ankets.answereditsave');
Route::post('/answerdelete', [App\Http\Controllers\AnketsController::class, 'answerDelete']) // Удаление ответа
                                ->middleware('auth', 'role')
                                ->name('layouts.ankets.answer_delete');

// ------------------------------------- end Страница "Анкеты" -------------------------------------






// ----------------------------------------- Звонобот ---------------------------------------------------

// Звонобот. Вывод страницы
Route::get('/zvonobot', [App\Http\Controllers\ZvonobotController::class, 'index']) // Форма + логи
                                ->middleware('auth', 'role')
                                ->name('zvonobot');

// Загрузить CSV
Route::post('/loadcsv', [App\Http\Controllers\ZvonobotController::class, 'loadcsv']) // Загрузить CSV от робота для заполнения анкет
                                ->middleware('auth', 'role')
                                ->name('layouts.zvonobot.loadcsv');

// Выгрузить Excel                                
Route::get('/loadexcel', [App\Http\Controllers\ZvonobotController::class, 'loadexcel'])
                                ->middleware('auth', 'role')
                                ->name('layouts.zvonobot.loadexcel');

// --------------------------------------- end Звонобот ---------------------------------------------------






// ----------------------------------------- Журнал событий ---------------------------------------------------

// Журнал событий
Route::get('/actionLog', [App\Http\Controllers\CallController::class, 'actionLog'])
                                ->middleware('auth', 'role')
                                ->name('actionlog');


// --------------------------------------- end Журнал событий -------------------------------------------------




       





Route::get('/startimport', [App\Http\Controllers\ImportController::class, 'startimport'])
                                ->middleware('auth', 'role')
                                ->name('startimport', 'role');

Route::get('/setonline', [App\Http\Controllers\UsersController::class, 'setOnLine'])
                                ->name('setonline');

Route::get('/test2', [App\Http\Controllers\ExportController::class, 'test'])
                    ->name('test');

Route::post('/test3', [App\Http\Controllers\ExportController::class, 'test'])
                    ->name('test3');




require __DIR__.'/auth.php';
