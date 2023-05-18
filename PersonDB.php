<?php
class PersonDB
{
    private $id;
    private $name;
    private $surname;
    private $birth_date;
    private $gender;
    private $birthCity;

    public function __construct($id = null, $name = '', $surname = '', $birth_date = '', $gender = 0, $birthCity = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->birth_date = $birth_date;
        $this->gender = $gender;
        $this->birthCity = $birthCity;

        if ($id !== null) {
            $this->fetchFromDatabase();
        } else {
            $this->saveToDatabase();
        }
    }

    public function saveToDatabase()
    {
        // Подключение к базе данных
        $pdo = new PDO('mysql:host=host;dbname= ', ' ', ' ');

        // Подготовка SQL-запроса для вставки данных
        $stmt = $pdo->prepare("INSERT INTO people (id, name, surname, birth_date, gender, birth_city) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$this->id, $this->name, $this->surname, $this->birth_date, $this->gender, $this->birthCity]);
    }

    public function deleteFromDatabase()
    {
        // Подключение к базе данных
        $pdo = new PDO('mysql:host=localhost;dbname=test', 'root', 'root');

        // Подготовка SQL-запроса для удаления записи
        $stmt = $pdo->prepare("DELETE FROM people WHERE id = ?");
        $stmt->execute([$this->id]);
    }

    public static function convertDateToAge($birth_date)
    {
        $birth_date = new DateTime($birth_date);
        $currentDate = new DateTime();
        $age = $currentDate->diff($birth_date)->y;
        return $age;
    }

    public static function convertGenderToText($gender)
    {
        return $gender === 0 ? 'муж' : 'жен';
    }

    public function formatPerson($formatAge = false, $formatGender = false)
    {
        $formattedPerson = new stdClass();
        $formattedPerson->id = $this->id;
        $formattedPerson->name = $this->name;
        $formattedPerson->surname = $this->surname;
    
        if ($formatAge) {
            $formattedPerson->age = self::convertDateToAge($this->birth_date);
        }
    
        if ($formatGender) {
            $formattedPerson->gender = self::convertGenderToText($this->gender);
        } else {
            $formattedPerson->gender = $this->gender;
        }
    
        return $formattedPerson;
    }
    

    private function fetchFromDatabase()
    {
        // Подключение к базе данных
        $pdo = new PDO('mysql:host=localhost;dbname=test', 'root', 'root');
    
        // Подготовка SQL-запроса для выборки данных по ID
        $stmt = $pdo->prepare("SELECT * FROM people WHERE id = ?");
        $stmt->execute([$this->id]);
    
        // Получение результата выборки
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row) {
            // Заполнение полей объекта данными из базы данных
            $this->name = $row['name'];
            $this->surname = $row['surname'];
            $this->birth_date = $row['birth_date'];
            $this->gender = $row['gender'];
            $this->birthCity = $row['birth_city'];
        }
    }
    
}
?>
