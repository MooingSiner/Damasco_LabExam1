<?php
include dirname(__DIR__)."/db.php";

$message = "";

if (isset($_POST['save'])){
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];

  if ($student_id=="" || $name=="" || $email=="" || $course==""){
    $message = "All fields are required";
  } else {
    $stmt = $conn->prepare("INSERT INTO student (student_id, name, email, course) VALUES ( ?, ?, ?, ?)");
    $stmt->bind_param("isss", $student_id, $name, $email, $course);
    $stmt->execute();
    if($stmt->affected_rows > 0){
      $message = "Student added successfully";
    } else {
      $message = "Error: " . $stmt->error;
    }
  }}
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
  </head>
  <body>
    <h2>Add Student</h2>
    <a href="../main.php">Back to Main</a><br><br>
    <a href="../pages/student_list.php">View Student List</a><br><br>
    <?php if ($message != ""): ?>
      <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post">
      <label for="student_id">ID Number:</label><br>
      <input type="number" id="student_id" name="student_id"><br><br>

      <label for="name">Name:</label><br>
      <input type="text" id="name" name="name" required><br><br>

      <label for="email">Email:</label><br>
      <input type="email" id="email" name="email" required><br><br>

      <label for="course">Course:</label><br>
      <input type="text" id="course" name="course" required><br><br>

      <input type="submit" name="save" value="Save">
  </body>
  </html>