<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Grade Distribution</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <h1>Grade Distribution by Course & Section</h1>
  <br>

  <?php
  $cnum = $_POST["CNumber"];
  $csnum = $_POST["CSNum"];

  $con = mysqli_connect("mariadb", "cs332u13", "prTEJ3Qs", "cs332u13");

  if (!$con) {
    die("Could not connect: " . mysqli_connect_error());
  }

  echo "<p>Connection successful</p><br>";

  $sql = "SELECT 
            E.GRADE, 
            COUNT(*) AS Grade_Count
          FROM ENROLLMENT E
          JOIN COURSE_SECTION CS ON E.CNum = CS.CNumber AND E.CSNum = CS.CSNum
          WHERE E.CNum = '$cnum' AND E.CSNum = '$csnum'
          GROUP BY E.GRADE
          ORDER BY FIELD(E.GRADE, 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'F');";

  $result = $con->query($sql);

  echo "<p>Course Number: $cnum</p>";
  echo "<p>Section Number: $csnum</p><br>";

  if ($result && $result->num_rows > 0) {
    echo "<table class = centered-table'>";
    echo "<tr><th>Grade</th><th>Count</th></tr>";
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $row["GRADE"] . "</td>";
      echo "<td>" . $row["Grade_Count"] . "</td>";
      echo "</tr>";
    }
    echo "</table><br>";
  } else {
    echo "<p>No grade data found for this course and section.</p>";
  }

  $result->free_result();
  $con->close();
?>

  <form action="professors.html">
    <input type="submit" value="Return Home">
  </form>

</body>

</html>
