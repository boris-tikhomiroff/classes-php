<?php
session_start();
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
            $pdo = new PDO("mysql:host=localhost;dbname=classes","root","", [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              ]);
        }
        catch(PDOException $e){
            echo 'Connexion échouée : ' . $e->getMessage();
        }
        return($pdo);
    }

    public function register($login, $password, $email, $firstname, $lastname){
        $db = $this->database();

        $queryAddUser = $db->prepare("INSERT INTO utilisateurs (login, password, email, firstname, lastname) values(?,?,?,?,?)");

        $queryAddUser->execute([
            "$login",
            "$password",
            "$email",
            "$firstname",
            "$lastname"
        ]);

        $queryUserInfo = $db->prepare("SELECT * from `utilisateurs` ORDER BY `id` DESC LIMIT 1");

        $queryUserInfo->execute();

        $resultUserInfo = $queryUserInfo->fetchAll(PDO::FETCH_ASSOC);

        return(var_dump($resultUserInfo));
    }

    public function connect($login ,$password){
        $db = $this->database();

        $queryLogin = $db->prepare("SELECT * FROM `utilisateurs` WHERE `login` = '$login'");

        $queryLogin->execute();

        $fetchUserInfos = $queryLogin->fetch(PDO::FETCH_ASSOC);
        // var_dump($fetchUserInfos);

        if($login == $fetchUserInfos['login'] && $password == $fetchUserInfos['password']){
            $this->login = $fetchUserInfos['login'];
            $this->password = $fetchUserInfos['password'];
            $this->email = $fetchUserInfos['email'];
            $this->firstname = $fetchUserInfos['firstname'];
            $this->lastname = $fetchUserInfos['lastname'];
            $_SESSION['login'] = $this->login;
            $_SESSION['password'] = $this->password;
            // echo "Vous êtes à présent connecté";
            
        }else {
            // echo "Login ou mot de passe incorrect";
        }
        
        return($fetchUserInfos);
    }

    public function disconnect(){
        unset($this->login);
        unset($this->password);
        unset($this->email);
        unset($this->firstname);
        unset($this->lastname);
        session_destroy();
    }

    public function delete(){
        $db = $this->database();
        $actifUser = $this->login;
        $queryDelete = $db->prepare("DELETE FROM `utilisateurs` WHERE `login` = '$actifUser'");
        $queryDelete->execute();
        session_destroy();

        return($queryDelete);
    }

    public function update($login, $password, $email, $firstname, $lastname){
        $db = $this->database();

        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $_SESSION['login'] = $this->login;
        $_SESSION['password'] = $this->password;
        $queryUpdate = $db->prepare("UPDATE `utilisateurs` SET `login` = '$login', `password` = '$password', `email` = '$email', `firstname` = '$firstname', `lastname` = '$lastname'");
        $queryUpdate->execute();

    }

    public function isConnected(){
        $connected = NULL;
        if(!empty($this->login && $this->password)){
            $connected = true;
        }else {
            $connected = false;
        }
        return (var_dump($connected));
    }

    public function getAllInfos(){
        $allInfos = 
        ['login'=>$this->login, 
        'password'=>$this->password, 
        'email'=>$this->email, 
        'firstname'=>$this->firstname, 
        'lastname'=>$this->lastname];
        return(var_dump($allInfos));
    }

    public function getLogin(){
        $userLogin = $this->login;
        return(var_dump($userLogin));
    }

    public function getEmail(){
        $userEmail = $this->email;
        return(var_dump($userEmail));
    }

    public function getFirstname(){
        $userFirstname = $this->firstname;
        return(var_dump($userFirstname));
    }

    public function getLastname(){
        $userLastname = $this->lastname;
        return(var_dump($userLastname));
    }
}
$User = new Userpdo();
// $User->register("JeanC", "123", "jc@gmail.com", "Jean", "Claude");
$User->connect("JeanCld", "123");
// $User->disconnect();
// $User->delete();
// $User->update("JeanC", "123", "jc@gmail.com", "Jean", "Claude");
// $User->isConnected();
// $User->getAllInfos();
// $User->getLogin();
// $User->getEmail();
// $User->getFirstname();
// $User->getLastname();

var_dump($User);
var_dump($_SESSION);