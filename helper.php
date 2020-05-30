<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = mysqli_connect("localhost", "root", "", "todo");
session_start();

function clean_input($data) {
  $data = htmlspecialchars($data);
  $data = stripcslashes($data);
  return $data;
}
?>