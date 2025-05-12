<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Student Grade Records</title>
</head>

<body>

  <h1>Student Grade Records</h1>

<?php

  $cwid = $_POST["CWID"];

  $cwid = $_POST["CWID"];

  // Connect to the database
  $con = mysqli_connect("mariadb", "cs332u13", "prTEJ3Qs", "cs332u13");

  if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
  }

  echo "<br>Connection successful<br><br>";

  $sql = "SELECT 
            E.CNum AS Course_Number,
            C.CTitle AS Course_Title,
            E.CSNum AS Section_Number,
            E.Grade
          FROM ENROLLMENT E
          JOIN COURSE C ON E.CNum = C.CNumber
          WHERE E.S_CWID = '$cwid';";

  $result = $con->query($sql);

  echo "<p>Student CWID: $cwid</p><br>";

  if ($result && $result->num_rows > 0) {
    echo "<table border='1' cellpadding='8'>";
    echo "<tr><th>Course Number</th><th>Title</th><th>Section</th><th>Grade</th></tr>";
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $row["Course_Number"] . "</td>";
      echo "<td>" . $row["Course_Title"] . "</td>";
      echo "<td>" . $row["Section_Number"] . "</td>";
      echo "<td>" . ($row["Grade"] ?? "N/A") . "</td>";
      echo "</tr>";
    }
    echo "</table><br>";
  } else {
    echo "No courses found for this student.<br><br>";
  }
$result->free_result();
$con->close();
?>

  <form action="students.html">
    <input type="submit" value="Return Home">
  </form>

</body>
</html>
