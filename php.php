<?php

$variable = $_GET['data'];
echo "variable is : .$variable";
    
class Funkcje{ 
    private $conn;
    public function __construct(){
        $this->conn = new mysqli("localhost", "root","","baza_danych");
        if($this->conn->connect_errno){
            printf("Polaczenie nieudane: %s\n", $this->conn->connect_error);
            exit();
        }
    }
    public function pokaz_uzytkownikow(){
        $result=mysqli_query($this->conn, "SELECT * FROM dane");
        $wynik = mysqli_num_rows($result);
        if($wynik>0){
            while($row=mysqli_fetch_assoc($result)){
                echo $row['login']."<br>";
            }
        }
    }
    public function is_in_db($login){
        $sql = "SELECT * FROM dane WHERE login='$login'";
        $result = mysqli_query($this->conn, $sql);
        if($result->num_rows){
            echo "Taki uzytkownik juz istnieje!";
            return true;
        }else{
            return false;
        }
    }
    public function dodaj_uzytkownika($login,$haslo){
        $sql = "SELECT * FROM dane WHERE login='$login'";
        $result = mysqli_query($this->conn, $sql);
        if($result->num_rows){
            return "Taki uzytkownik juz istnieje!";
        }else{
            $sql2 = "INSERT INTO dane(login,haslo) VALUES('$login','$haslo')";
            if(mysqli_query($this->conn,$sql2)){
                return "Dodano uzytkownika do bazy danych!";
            }else{
                return "Nie udalo sie dodac uzytkownika do bazy danych".mysqli_error($this->conn);
            }
        }
    }
    public function usun_uzytkownika($login){
        $sql = "DELETE FROM dane WHERE login='$login'";  
        $sql2 = "SELECT * FROM dane WHERE login='$login'";
        $result=mysqli_query($this->conn,$sql2);
        if ($result->num_rows){
            if(mysqli_query($this->conn,$sql)){
                echo "Usunieto uzytkownika!";
                $sql1="ALTER TABLE dane AUTO_INCREMENT=value";
                    if (mysqli_query($this->conn, $sql1))
                        echo 'zrobioned';
            }
        }else{
            echo "Blad! Nie ma takiego uzytkownika!";
        }
    }
    public function zaloguj($login,$haslo){
        $sql1="SELECT login FROM dane WHERE login='$login'";
        $sql2 = "SELECT haslo FROM dane WHERE haslo='$haslo'";
        $l = mysqli_query($this->conn, $sql1);
        if($l->num_rows)
            $_login = mysqli_fetch_row($l);
        else
            return 'Niepoprawne dane!';
        $h = mysqli_query($this->conn, $sql2);
        if($h->num_rows)
            $_haslo = mysqli_fetch_row($h);
        else
            return 'Niepoprawne dane!';

        if($login!=$_login[0])
            return 'Nie ma takiego uzytkownika!';
        elseif($haslo!=$_haslo[0])
            return 'Niepoprawne haslo!';
        else
            return 'Zalogowano!';   
    }
    
}



?>