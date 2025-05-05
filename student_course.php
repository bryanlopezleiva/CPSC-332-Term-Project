<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Student's Database</title>
</head>

<body>

  <h1>Student's Database</h1>

  <!-- Input Form -->
  <form method="POST" action="">
    <label for="CourseNumber">Enter Course Number:</label>
    <input type="text" name="CourseNumber" id="CourseNumber" placeholder="e.g., MATH-338" required>
    <input type="submit" value="Search">
  </form>

  <form action="students.html">
    <input type="submit" value="Return Home">
  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $courseNum = $_POST["CourseNumber"];

    // change this
    $con = new mysqli("", "", "", "");

    if ($con->connect_error) {
      echo "<br>Connection failed: " . $con->connect_error;
    } else {
      echo "<br>Connection successful<br><br>";

      // Escape input to prevent SQL injection (better to use prepared statements in production)
      $courseNum = $con->real_escape_string($courseNum);

      $sql = "SELECT 
    CS.CSNum AS Section_Number, 
    CS.CLASSROOM, 
    CS.Meeting_Days, 
    CS.BEGIN_TIME, 
    CS.END_TIME,  
    COUNT(*) AS Num_Enrolled
FROM COURSE_SECTION CS, ENROLLMENT E
WHERE CS.CSNum = E.CSNum 
    AND CS.CNumber = E.CNum 
    AND CS.CNumber = '$courseNum'
GROUP BY CS.CSNum, CS.CLASSROOM, CS.Meeting_Days, CS.BEGIN_TIME, CS.END_TIME;";

      $result = $con->query($sql);

      echo "Course Number: ", htmlspecialchars($courseNum), "<br><br>";

      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "Course Section: ", $row["Section_Number"], "<br>";
          echo "Classroom: ", $row["CLASSROOM"], "<br>";
          echo "Meeting Days: ", $row["Meeting_Days"], "<br>";
          echo "Begin Time: ", $row["BEGIN_TIME"], "<br>";
          echo "End Time: ", $row["END_TIME"], "<br>";
          echo "Number Enrolled: ", $row["Num_Enrolled"], "<br><br>";
        }
      } else {
        echo "No results found.<br><br>";
      }

      $result?->free_result();
      $con->close();
    }
  }
  ?>

</body>

</html>
