<?php
include dirname(__DIR__)."/db.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    echo 'Invalid student ID';
    exit;
}

$stmt = $conn->prepare("SELECT * FROM student WHERE ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$get     = $stmt->get_result();
$student = $get->fetch_assoc();

if (!$student) {
    echo 'Student not found';
    exit;
}

$message = "";
if(isset($_POST['update'])){
    $stuid = $_POST['student_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];

  if ($stuid=="" || $name=="" || $email=="" || $course==""){
    $message = "All fields are required";
  } else {
     $stmt = $conn->prepare(
            "UPDATE student SET student_id=?, name=?, email=?, course=? WHERE ID=?"
        );
        $stmt->bind_param("isssi", $stuid, $name, $email, $course, $id);
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
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2 class="mb-4">Edit Student</h2>
                <div class="btn-group mb-3" role="group">
                    <a href="../main.php" class="btn btn-secondary">Back to Main</a>
                    <a href="../pages/student_list.php" class="btn btn-info">View Student List</a>
                </div>
            </div>
        </div>

        <?php if ($message != ""): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label for="student_id" class="form-label">ID Number:</label>
                                <input type="number" class="form-control" id="student_id" name="student_id" value="<?php echo htmlspecialchars($student['student_id']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="course" class="form-label">Course:</label>
                                <input type="text" class="form-control" id="course" name="course" value="<?php echo htmlspecialchars($student['course']); ?>" required>
                            </div>

                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>