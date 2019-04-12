<?php
$roll = $_POST['roll'];
  $id = $_POST['id'];
  $email = $_POST['email'];
  $url = 'https://zarainforise.com/google/hello.php?' . 'roll='. $roll . '&' . 'id=' . $id . '&' . 'email=' . $email;

  echo json_encode(file_get_contents($url));
?>