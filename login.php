<?php

session_start();

if (isset($_SESSION["username"])) {
  echo "Esti logat cu " . $_SESSION["username"] . "<br />";
  echo "Logout <a href='logout.php'> </a>";
  exit();
}
if (!isset($_POST["username"]) || !isset($_POST["password"])) {
  echo "Introuceti username si password";
} else {
  $db = mysqli_connect("127.0.0.1", "root", "", "test");
  $query = "select username from users where username = ? and password = SHA(?)";
  $statement = $db->prepare($query);
  $statement->bind_param("ss", $_POST["username"], $_POST["password"]);
  $statement->execute();
  $result = $statement->get_result();
  if ($result->num_rows == 1) {
      $row = $result->fetch_array();
      $username = $row['username'];
      $_SESSION["username"] = $username;
      header("Location: index.php");
      exit();
  } else {
     echo "user sau parola gresite";
  }
}
?>
<form action="login.php" method="POST">
  <label for="username">Username:</label>
  <input name="username" type="text"/>
  <br/>
  <label for="password">Password:</label>
  <input name="password" type="password"/>
  <br/>
  <input type="submit" value="Login"/>
</form>


