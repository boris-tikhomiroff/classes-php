<?php

class Userpdo {
    private $id;
    public $login;
    public $password;
    public $email;
    public $firstname;
    public $lastname;

    public function __construct(){
        $this->login;
        $this->password;
        $this->email;
        $this->firstname;
        $this->lastname;
    }

    public function database(){
        try{
            $pdo = new PDO("mysql:host=localhost;dbname=classes","root","");
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
        return($pdo);
    }

    public function register($login, $password, $email, $firstname, $lastname){
        $db = $this->database();

        $queryAddUser = $db->prepare("insert into utilisateurs (login, password, email, firstname, lastname) values(?,?,?,?,?)");
        $queryAddUser->execute(array("$login","$password","$email","$firstname", "$lastname"));

        
        $queryUserInfo = $db->prepare("SELECT * from `utilisateurs` ORDER BY `id` DESC LIMIT 1");
    }   
}
$User = new Userpdo();
$User->register("bobibob", "bobo", "boris", "tikho", "tikho");