<?php

/*---------------------------------
|
|   Общий класс для загрузок файлов (на примере CSV)
|   Нужен для:
|       1.  Прием файла как вообще
|       2.  Распарсивание содержимого
|       3.  Первая проверка загрузки файла: 1) если файл вообще загружен; 2) если расширение подлинное
|
*/

namespace App\Services;

abstract class getFile
{
    public $controlExtension; // Расширение файла, которое нам нужно. Обозначается в наследуемом классе
    public $nameInputFile = 'csvFile'; // Название параметра "name" в форме input[type="file"]    
    public $nameDirectoryUploads = 'uploads'; // Название папки, куда загружается CSV, которая находится в storage/app
    public $errors = []; // Массив ошибок валидации на файл
    public $originalFileName; // Оригинальное название файла файл    
    public $parser; // библиотека для распарсивания файла (вызываем подходящий класс вызываем в контрукторе в наследуемом классе)
    public $row = 0; // Счетчик строк когда считываем файл
    public $row2 = 0; // Счетчик когда встречаются нужные

    public $contentFile; // Сюда кладем содержимое файла

    public function getExtension($request){ // Получаем расширение файла
        $this->originalFileName = $request->file($this->nameInputFile)->getClientOriginalName();
        $extension = substr($this->originalFileName, strlen($this->originalFileName)-4, 4); // Расширение файла
        return strtolower($extension);
    }
    public function setPatch($request){
        return storage_path('app/') . $request->file($this->nameInputFile)->storeAs($this->nameDirectoryUploads, $this->nameInputFile . $this->getExtension($request));
    }
    public function getContentFile($request){
        return $this->parser->getData($this->setPatch($request), $file_encodings = ['cp1251','UTF-8'], $col_delimiter = ';', $row_delimiter = '');
    }    
    public function setErrors($col, $desc){} // Кладем в массив данные об ошибках (добавляется функционал в этот метод в наследуемом классе)

    public function validLoadFile($request){ // Первая проверка загрузки файла: 1) если файл вообще загружен; 2) если расширение подлинное
        if (!$request->hasFile($this->nameInputFile)) $this->setErrors(-1, 'Вы не загрузили файл'); // Если файл не пришел
        if (count($this->errors) == 0) if ($this->getExtension($request) != '.' . $this->controlExtension) $this->setErrors(-1, 'Вы загрузили файл с другим расширением'); // Если расширение файла подходит
        if (count($this->errors) == 0) return true;
    }

}
