<?php
session_start();
class User {
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
        $host = "localhost";
        $user = "root";
        $password = "";
        $dbName = "classes";
        $db = mysqli_connect("$host", "$user", "$password", "$dbName");
        mysqli_set_charset($db, 'utf8');

        return ($db);
    }

    public function register($login, $password, $email, $firstname, $lastname){
        $con = $this->database();
        $queryAddUser = mysqli_query($con, "INSERT INTO `utilisateurs`( `login`, `password`, `email`, `firstname`, `lastname`) VALUES ('$login', '$password', '$email', '$firstname', '$lastname')");
        
        $queryUserInfo = mysqli_query($con, "SELECT * from `utilisateurs` ORDER BY `id` DESC LIMIT 1");
        $resultUserInfo = mysqli_fetch_assoc($queryUserInfo);
        
        foreach($resultUserInfo as $key => $infos){
            echo    
                "<table>
                    <thead>
                        <th>$key</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>$infos</td>
                        </tr>
                    </tbody>
                </table>";
        }
    }

    public function connect($login, $password){
        $con = $this->database();

        $queryLogin = mysqli_query($con , "SELECT * FROM `utilisateurs` WHERE `login` = '$login'");
        $fetchUserInfos = mysqli_fetch_assoc($queryLogin);

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
        $con = $this->database();

        $actifUser = $this->login;
        $queryDelete = mysqli_query($con, "DELETE FROM `utilisateurs` WHERE `login` = '$actifUser'");
        session_destroy();

        return($queryDelete);
    }

    public function update($login, $password, $email, $firstname, $lastname){
        $con = $this->database();

        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $_SESSION['login'] = $this->login;
        $_SESSION['password'] = $this->password;
        $queryUpdate = mysqli_query($con,"UPDATE `utilisateurs` SET `login` = '$login', `password` = '$password', `email` = '$email', `firstname` = '$firstname', `lastname` = '$lastname'");
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

$User = new User();
// $User->register("test", "test", "test", "test", "test");
// $User->connect("test", "test");
// $User->disconnect();
// $User->delete();
// $User->update("T", "T", "T", "T", "T");
// $User->isConnected();
// $User->getAllInfos();
// $User->getLogin();
// $User->getEmail();
// $User->getFirstname();
// $User->getLastname();

var_dump($User);
var_dump($_SESSION);