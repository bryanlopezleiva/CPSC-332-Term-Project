<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Grade Distribution</title>
</head>

<body>

  <h1>Grade Distribution by Course & Section</h1>

  <!-- Input Form -->
  <form method="POST" action="">
    <label for="CNumber">Enter Course Number:</label>
    <input type="text" name="CNumber" id="CNumber" placeholder="e.g., MATH-338" required>
    <br><br>
    <label for="CSNum">Enter Section Number:</label>
    <input type="text" name="CSNum" id="CSNum" placeholder="e.g., 01" required>
    <br><br>
    <input type="submit" value="Search">
  </form>

  <br>

  <form action="professors.html">
    <input type="submit" value="Return Home">
  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cnum = $_POST["CNumber"];
    $csnum = $_POST["CSNum"];

    // change this
    $con = new mysqli("", "", "", "");

    if ($con->connect_error) {
      echo "<br>Connection failed: " . $con->connect_error;
    } else {
      echo "<br>Connection successful<br><br>";

      // Escape input (use prepared statements in production)
      $cnum = $con->real_escape_string($cnum);
      $csnum = $con->real_escape_string($csnum);

      $sql = "SELECT 
                E.GRADE, 
                COUNT(*) AS Grade_Count
              FROM ENROLLMENT E
              JOIN COURSE_SECTION CS ON E.CNum = CS.CNumber AND E.CSNum = CS.CSNum
              WHERE E.CNum = '$cnum' AND E.CSNum = '$csnum'
              GROUP BY E.GRADE
              ORDER BY FIELD(E.GRADE, 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'F', 'W', 'I');";

      $result = $con->query($sql);

      echo "Course Number: ", htmlspecialchars($cnum), "<br>";
      echo "Section Number: ", htmlspecialchars($csnum), "<br><br>";

      if ($result && $result->num_rows > 0) {
        echo "<table border='1' cellpadding='8'>";
        echo "<tr><th>Grade</th><th>Count</th></tr>";
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($row["GRADE"]) . "</td>";
          echo "<td>" . $row["Grade_Count"] . "</td>";
          echo "</tr>";
        }
        echo "</table><br>";
      } else {
        echo "No grade data found for this course and section.<br><br>";
      }

      $result?->free_result();
      $con->close();
    }
  }
  ?>

</body>

</html>
