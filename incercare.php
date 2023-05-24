<?php
$conn = mysqli_connect("localhost:4306", "root", "", "consultants");

if (!$conn) {
    die("Conexiunea la baza de date a eșuat: " . mysqli_connect_error());
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username)) {
        $stmt = mysqli_prepare($conn, "SELECT *FROM consultants WHERE username = ?");
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($count > 0) {
            echo 'error';
        } else {
            $stmt = mysqli_prepare($conn, "INSERT INTO consultants (username, password) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmt, 'ss', $username, $password);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            echo 'success';
        }
    } else {
        echo 'error';
    }
} else {
    echo 'errordate';
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html>
    <head>
        <style>
            
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
  }
  
  .modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 300px;
  }
  
  .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
  }
  
  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }
  
        </style>
    </head>
<head>
  <title>Formular de logare și înregistrare</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="script.js"></script>
</head>
<body>
  <h2>Logare</h2>
  <form id="login-form">
    <input type="text" id="username" placeholder="Utilizator" required><br>
    <input type="password" id="password" placeholder="Parola" required><br>
    <input type="submit" value="Logare">
    <button id="register-btn">Înregistrare</button>
  </form>
  <div id="error-message" style="color: red;"></div>

  <div id="register-modal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Înregistrare</h2>
      <form id="register-form">
        <input type="text" id="register-username" name="username" placeholder="Utilizator" required><br>
        <input type="password" id="register-password" name="password" placeholder="Parola" required><br>

        <input type="submit" value="Înregistrare">
      </form>
      <a href="calendar.php" class="btn btn-default">Nu sunt consultant doresc o programare</a>
      <div id="register-error-message" style="color: red;"></div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
    $('#login-form').submit(function(event) {
      event.preventDefault();
  
      var username = $('#username').val();
      var password = $('#password').val();
  
      $.ajax({
        url: 'app.php',
        method: 'POST',
        data: {
          username: username,
          password: password
        },
        success: function(response) {
          if (response === 'success') {
            window.location.href = 'app.html';
          } else {
            $('#error-message').text('Numele de utilizator sau parola sunt incorecte.');
          }
        }
      });
    });
  
    $('#register-btn').click(function() {
      $('#register-modal').css('display', 'block');
    });
  
    $('.close').click(function() {
      $('#register-modal').css('display', 'none');
      $('#register-error-message').text('');
    });

    $('#register-form').submit(function(event) {
      event.preventDefault();
  
      var username = $('#register-username').val();
      var password = $('#register-password').val();
  
      $.ajax({
        url: 'app.php',
        method: 'POST',
        data: {
          username: username,
          password: password
        },
        success: function(response) {
          if (response === 'success') {
            alert('Înregistrarea a fost efectuată cu succes!');
            $('#register-modal').css('display', 'none');
            $('#register-username').val('');
            $('#register-password').val('');
          } else {
            $('#register-error-message').text('Eroare la înregistrare. Vă rugăm să încercați din nou.');
          }
        }
      });
    });
  });
  </script>

</body>
</html>

  