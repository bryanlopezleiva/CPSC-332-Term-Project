<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Professor Schedule</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <h1>Professor's Class Schedule</h1>

  <?php
  $ssn = $_POST["SSN"];

  $con =  mysqli_connect("mariadb", "cs332u13", "prTEJ3Qs", "cs332u13");

  if (!$con) {
    die("Could not connect: " . mysqli_connect_error());
  }

  echo "<p>Connected successfully</p>";

  $result = $con->query("SELECT 
                            C.CTitle AS Course_Title, 
                            CS.CLASSROOM, 
                            CS.Meeting_Days, 
                            CS.BEGIN_TIME, 
                            CS.END_TIME
                          FROM PROFESSOR P
                          JOIN COURSE_SECTION CS ON P.SSN = CS.P_SSN
                          JOIN COURSE C ON C.CNumber = CS.CNumber
                          WHERE P.SSN = '$ssn'");

  echo "<br>", "<p>Professor SSN: $ssn</p>","<br>";

  if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo "<div class='result-block'>";
      echo "<strong>Course Title:</strong> " . $row["Course_Title"] . "<br>";
      echo "<strong>Classroom:</strong> " . $row["CLASSROOM"] . "<br>";
      echo "<strong>Meeting Days:</strong> " . $row["Meeting_Days"] . "<br>";
      echo "<strong>Begin Time:</strong> " . $row["BEGIN_TIME"] . "<br>";
      echo "<strong>End Time:</strong> " . $row["END_TIME"] . "<br><br>";
      echo "</div>";
    }
  } else {
    echo "<p>No classes found for this professor.</p>";
  }

  $result->free_result();
  $con->close();
  ?>
<form action = "professor_ssn.html">
<button type = "submit"> Return to Professor Home Page </button>
</form>

</body>

</html>
