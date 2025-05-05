<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Student's Course History</title>
</head>

<body>

  <h1>Student's Course History</h1>

  <!-- Input Form -->
  <form method="POST" action="">
    <label for="CWID">Enter Student CWID:</label>
    <input type="text" name="CWID" id="CWID" placeholder="e.g., 123456789" required>
    <input type="submit" value="Search">
  </form>

  <form action="students.html">
    <input type="submit" value="Return Home">
  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cwid = $_POST["CWID"];

    // changing this later
    $con = new mysqli("", "", "", "");

    if ($con->connect_error) {
      echo "<br>Connection failed: " . $con->connect_error;
    } else {
      echo "<br>Connection successful<br><br>";

      // Escape input (for demo purposes only — prepared statements are better)
      $cwid = $con->real_escape_string($cwid);

      $sql = "SELECT 
                E.CNum AS Course_Number,
                C.CTitle AS Course_Title,
                E.CSNum AS Section_Number,
                E.Grade
              FROM ENROLLMENT E
              JOIN COURSE C ON E.CNum = C.CNumber
              WHERE E.S_CWID = '$cwid';";

      $result = $con->query($sql);

      echo "Student CWID: ", htmlspecialchars($cwid), "<br><br>";

      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "Course Number: ", $row["Course_Number"], "<br>";
          echo "Course Title: ", $row["Course_Title"], "<br>";
          echo "Section Number: ", $row["Section_Number"], "<br>";
          echo "Grade: ", $row["Grade"] ?? "N/A", "<br><br>";
        }
      } else {
        echo "No courses found for this student.<br><br>";
      }

      $result?->free_result();
      $con->close();
    }
  }
  ?>

</body>

</html>
