<?php 
include "config.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Rejestracja</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <?php 
$error_message = "";$success_message = "";

if(isset($_POST['btnsignup'])){
   $login = trim($_POST['login']);
   $password = trim($_POST['password']);
   $confirmpassword = trim($_POST['confirmpassword']);

   $isValid = true;

   if($login == '' ||$password == '' || $confirmpassword == ''){
     $isValid = false;
     $error_message = "Wypelnij wszystkie pola.";
   }

   if($isValid && ($password != $confirmpassword) ){
     $isValid = false;
     $error_message = "Hasla do siebie nie pasuja!";
   }

   if($isValid){
            $stmt = $con->prepare("SELECT * FROM dane WHERE login=?");
            $stmt->bind_param("s", $login);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                $isValid = false;
                $error_message = "Login zajety!";
            }
   }


   if($isValid){
     $insertSQL = "INSERT INTO dane(login,haslo) values(?,?)";
     $stmt = $con->prepare($insertSQL);
     $stmt->bind_param('ss',$login,$password);
     $stmt->execute();
     $stmt->close();

     $success_message = "Konto utworzone z sukcesem!";
   }
}
?>

  </head>
  <body>
    <div class='container'>
      <div class='row'>

        <div class='col-md-6' >

          <form method='post' action=''>

            <h1>Zarejestruj sie</h1>
            <?php 
            if(!empty($error_message)){
            ?>
            <div class="alert alert-danger">
              <strong>Blad!</strong> <?= $error_message ?>
            </div>

            <?php
            }
            ?>

            <?php 
            if(!empty($success_message)){
            ?>
            <div class="alert alert-success">
              <strong>Sukces!</strong> <?= $success_message ?>
            </div>

            <?php
            }
            ?>

            <div class="form-group">
              <label for="login">Login:</label>
              <input type="text" class="form-control" name="login" id="login" required="required" maxlength="80">
            </div>
            <div class="form-group">
              <label for="password">Haslo:</label>
              <input type="password" class="form-control" name="password" id="password" required="required" maxlength="80">
            </div>
            <div class="form-group">
              <label for="pwd">Potwiedz haslo:</label>
              <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" onkeyup='' required="required" maxlength="80">
            </div>

            <button type="submit" name="btnsignup" class="btn btn-default">Potwierdz</button>
          </form>
        </div>

     </div>
    </div>
  </body>
</html>