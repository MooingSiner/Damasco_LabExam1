<?php
include dirname(__DIR__)."/db.php";

$id = $_GET['id'];

$stmt = $conn ->prepare("SELECT * FROM student WHERE id = ?");
$stmt -> bind_param("i",$id);
$stmt->execute();
$get = $stmt->get_result();
$student = mysqli_fetch_assoc($get);

$message ="";

if(isset($_POST['update'])){
    $stuid = $_POST['student_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];

  if ($id=="" || $name=="" || $email=="" || $course==""){
    $message = "All fields are required";
  } else {
    $stmt = $conn->prepare("UPDATE student SET student_id=?, name=?, email=?, course=? WHERE id=?");
    $stmt->bind_param("isssi", $stuid, $name, $email, $course,$stuid);
    $stmt->execute();
    if($stmt->affected_rows > 0){
      $message = "Student edited successfully";
    } else {
      $message = "Error: " . $stmt->error;
    }
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Edit</title>
</head>
<body>
    <h2>Edit Student</h2>
    <a href="../main.php">Back to Main</a><br><br>
    <a href="../pages/student_list.php">View Student List</a><br><br>
    <?php if ($message != ""): ?>
      <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post">
      <label for="student_id">ID Number:</label><br>
      <input type="number" id="student_id" name="student_id" value="<?php echo htmlspecialchars($student['student_id']); ?>" required><br><br>
      <label for="name">Name:</label><br>
      <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required><br><br>

      <label for="email">Email:</label><br>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required><br><br>

      <label for="course">Course:</label><br>
      <input type="text" id="course" name="course" value="<?php echo htmlspecialchars($student['course']); ?>" required><br><br>

      <input type="submit" name="update" value="Update">
    </form>
</html>
