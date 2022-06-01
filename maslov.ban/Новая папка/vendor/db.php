<?php
class db{
    private $link;

    public function __construct(){
        $this->connect();
    }

    private function connect(){
        $driver = 'mysql';
        $host = 'localhost';
        $db_name = 'maslov';
        $db_user = 'root';
        $db_password = 'root';
        $charset = 'utf8';

        try{
            $this->link = new PDO("$driver:host=$host;dbname=$db_name;charset=$charset", $db_user, $db_password);
        }catch(PDOException $e){
            die('Нет подключения к базе данных. Ошибка - ' . $e->getMessage());
        }
    }

    //метод для запросов поиска
    public function query($sql, $params = []){
        $sth = $this->link->prepare($sql); //Подготавливает запрос к выполнению и возвращает связанный с этим запросом объект
        $sth->execute($params); //Запускает подготовленный запрос на выполнение
        $result = $sth->fetchAll(PDO::FETCH_ASSOC); //Возвращает массив, содержащий все строки результирующего набора

        if (!$result){return [];}
        return $result;
    }

    //метод для добавления, удаления, изменения данных, если успешно то возвратит 1
    public function make($sql, $params = []){
        $sth = $this->link->prepare($sql); //Подготавливает запрос к выполнению и возвращает связанный с этим запросом объект
        return $sth->execute($params); //Запускает подготовленный запрос на выполнение
    }
}

$db = new db();