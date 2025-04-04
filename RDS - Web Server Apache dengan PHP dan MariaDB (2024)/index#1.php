<?php include "/var/www/inc/koneksi.inc"; ?>
<html>
<body>
<h1>Data Server 1</h1>
<?php

  /* Connect to MySQL and select the database. */
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

  $database = mysqli_select_db($connection, DB_DATABASE);

  /* Ensure that the EMPLOYEES table exists. */
  VerifyEmployeesTable($connection, DB_DATABASE);

  /* If input fields are populated, add a row to the EMPLOYEES table. */
  $employee_kategori = htmlentities($_POST['KATEGORI']);
  $employee_judul = htmlentities($_POST['JUDUL']);
  $employee_editor = htmlentities($_POST['EDITOR']);

  if (strlen($employee_kategori) || strlen($employee_judul) || strlen ($employee_editor)) {
    AddEmployee($connection, $employee_kategori, $employee_judul, $employee_editor);
  }
?>

<!-- Input form -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>
      <td>KATEGORI</td>
      <td>JUDUL</td>
      <td>EDITOR</td>
    </tr>
    <tr>
      <td>
        <input type="text" name="KATEGORI" maxlength="45" size="30" />
      </td>
      <td>
        <input type="text" name="JUDUL" maxlength="90" size="60" />
      </td>
      <td>
      <input type="text" name="EDITOR" maxlength="45" size="30" />
      </td>
      <td>
        <input type="submit" value="Add Data" />
      </td>
    </tr>
  </table>
</form>

<!-- Display table data. -->
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>KATEGORI</td>
    <td>JUDUL</td>
    <td>EDITOR</td>
  </tr>

<?php

$result = mysqli_query($connection, "SELECT * FROM EMPLOYEES");

while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
       "<td>",$query_data[1], "</td>",
       "<td>",$query_data[2], "</td>",
       "<td>",$query_data[3], "</td>";
  echo "</tr>";
}
?>

</table>

<!-- Clean up. -->
<?php

  mysqli_free_result($result);
  mysqli_close($connection);

?>

</body>
</html>


<?php

/* Add an employee to the table. */
function AddEmployee($connection, $kategori, $judul, $editor) {
   $k = mysqli_real_escape_string($connection, $kategori);
   $j = mysqli_real_escape_string($connection, $judul);
   $e = mysqli_real_escape_string($connection, $editor);

   $query = "INSERT INTO EMPLOYEES (KATEGORI, JUDUL, EDITOR) VALUES ('$k', '$j', '$e');";

   if(!mysqli_query($connection, $query)) echo("<p>Error adding employee data.</p>");
}

/* Check whether the table exists and, if not, create it. */
function VerifyEmployeesTable($connection, $dbName) {
  if(!TableExists("EMPLOYEES", $connection, $dbName))
  {
     $query = "CREATE TABLE EMPLOYEES (
         ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
         KATEGORI VARCHAR(45),
         JUDUL VARCHAR(90),
         EDITOR VARCHAR(45)
       )";

     if(!mysqli_query($connection, $query)) echo("<p>Error creating table.</p>");
  }
}

/* Check for the existence of a table. */
function TableExists($tableName, $connection, $dbName) {
  $t = mysqli_real_escape_string($connection, $tableName);
  $d = mysqli_real_escape_string($connection, $dbName);

  $checktable = mysqli_query($connection,
      "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

  if(mysqli_num_rows($checktable) > 0) return true;

  return false;
}
?>
