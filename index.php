<?php
require_once 'PersonDB.php';
require_once 'PersonList.php';

// Создание объекта PersonDB и сохранение его в базе данных
$person = new PersonDB(null, 'John', 'Doe', '1990-01-01', 0, 'New York');

// Удаление человека из базы данных по его ID
$personToDelete = new PersonDB(72);
$personToDelete->deleteFromDatabase();

// Преобразование даты рождения в возраст
$birthdate = '1995-05-10';
$age = PersonDB::convertDateToAge($birthdate);
echo "Age: $age<br>";

// Преобразование пола из двоичной системы в текстовую
$genderBinary = 1;
$genderText = PersonDB::convertGenderToText($genderBinary);
echo "Gender: $genderText<br>";

// Форматирование информации о человеке с преобразованием возраста и пола
$personToFormat = new PersonDB(2, 'Jane', 'Smith', '1988-06-15', 1, 'London');
$formattedPerson = $personToFormat->formatPerson(true, true);
print_r($formattedPerson);

// Создание объекта PersonList и поиск людей в базе данных по условиям
$conditions = ['gender' => 0, 'birth_city' => 'Paris'];
$personList = new PersonList($conditions);

// Получение массива экземпляров класса PersonDB из массива ID людей
$people = $personList->getPeople();
foreach ($people as $person) {
    echo "ID: {$person->id}, Name: {$person->name}, Surname: {$person->surname}<br>";
}

// Удаление людей из базы данных, соответствующих условиям
$personList->deletePeople();
?>
