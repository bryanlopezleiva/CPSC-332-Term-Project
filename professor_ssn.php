<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Professor's Class Schedule</title>
</head>

<body>

  <h1>Professor's Class Schedule</h1>

  <!-- Input Form -->
  <form method="POST" action="">
    <label for="SSN">Enter Professor SSN:</label>
    <input type="text" name="SSN" id="SSN" placeholder="e.g., 123-45-6789" required>
    <input type="submit" value="Search">
  </form>

  <br>

  <form action="professors.html">
    <input type="submit" value="Return Home">
  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ssn = $_POST["SSN"];

    $con = new mysqli("", "", "", "");

    if ($con->connect_error) {
      echo "<br>Connection failed: " . $con->connect_error;
    } else {
      echo "<br>Connection successful<br><br>";

      // Escape input (use prepared statements in production)
      $ssn = $con->real_escape_string($ssn);

      $sql = "SELECT 
                C.CTitle AS Course_Title, 
                CS.CLASSROOM, 
                CS.Meeting_Days, 
                CS.BEGIN_TIME, 
                CS.END_TIME
              FROM PROFESSOR P
              JOIN COURSE_SECTION CS ON P.SSN = CS.P_SSN
              JOIN COURSE C ON C.CNumber = CS.CNumber
              WHERE P.SSN = '$ssn';";

      $result = $con->query($sql);

      echo "Professor SSN: ", htmlspecialchars($ssn), "<br><br>";

      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "Course Title: ", $row["Course_Title"], "<br>";
          echo "Classroom: ", $row["CLASSROOM"], "<br>";
          echo "Meeting Days: ", $row["Meeting_Days"], "<br>";
          echo "Begin Time: ", $row["BEGIN_TIME"], "<br>";
          echo "End Time: ", $row["END_TIME"], "<br><br>";
        }
      } else {
        echo "No classes found for this professor.<br><br>";
      }

      $result?->free_result();
      $con->close();
    }
  }
  ?>

</body>

</html>
