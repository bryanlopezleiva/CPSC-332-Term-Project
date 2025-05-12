<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style.css">
  <title>Student's Course Info</title>  
</head>

<body>

  <h1>Student Grade Records</h1>

  <?php
  $courseNum = $_POST["CourseNumber"];

  $con = mysqli_connect("mariadb", "cs332u13", "prTEJ3Qs", "cs332u13");

  if (!$con) {
    die("Could not connect: " . mysqli_connect_error());
  }

  $sql = "SELECT CS.CSNum AS Section_Number, CS.CLASSROOM, CS.Meeting_Days, CS.BEGIN_TIME, CS.END_TIME,
                 COUNT(E.S_CWID) AS Num_Enrolled
          FROM COURSE_SECTION CS, ENROLLMENT E
          WHERE CS.CSNum = E.CSNum 
            AND CS.CNumber = E.CNum 
            AND CS.CNumber = '$courseNum'
          GROUP BY CS.CSNum, CS.CLASSROOM, CS.Meeting_Days, CS.BEGIN_TIME, CS.END_TIME;";

  $result = $con->query($sql);

  if (!$result || $result->num_rows <= 0) {
    echo "No data found!<br>";
  } else {
    while ($row = $result->fetch_assoc()) {
      echo "Course Section: " . $row["Section_Number"] . "<br>";
      echo "Classroom: " . $row["CLASSROOM"] . "<br>";
      echo "Meeting Days: " . $row["Meeting_Days"] . "<br>";
      echo "Begin Time: " . $row["BEGIN_TIME"] . "<br>";
      echo "End Time: " . $row["END_TIME"] . "<br>";
      echo "Number Enrolled: " . $row["Num_Enrolled"] . "<br><br>";
    }
  }
  $result->free_result();
  $con->close();
  ?>

  <form action="students.html">
    <input type="submit" value="Return Home">
  </form>

</body>
</html>
