<?php
require_once 'PersonDB.php';

class PersonList
{
    private $peopleIds;

    public function __construct($conditions = [])
    {
        $this->findPeopleIds($conditions);
    }

    public function getPeople()
    {
        $people = [];
        foreach ($this->peopleIds as $personId) {
            $person = new PersonDB($personId);
            $people[] = $person;
        }
        return $people;
    }

    public function deletePeople()
    {
        foreach ($this->peopleIds as $personId) {
            $person = new PersonDB($personId);
            $person->deleteFromDatabase();
        }
    }

    private function findPeopleIds($conditions = [])
    {
        // Подключение к базе данных
        $pdo = new PDO('mysql:host=localhost;dbname=test', 'root', 'root');

        // Подготовка SQL-запроса для поиска людей по условиям
        $query = "SELECT id FROM people";
        $params = [];

        if (!empty($conditions)) {
            $query .= " WHERE ";
            $conditionsArr = [];
            foreach ($conditions as $field => $value) {
                $conditionsArr[] = "$field = ?";
                $params[] = $value;
            }
            $query .= implode(" AND ", $conditionsArr);
        }

        // Выполнение запроса с параметрами
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);

        // Получение результата выборки
        $this->peopleIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
?>
