<?php
include dirname(__DIR__)."/db.php";

$sql ="
SELECT * FROM student";

$result =mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
</head>
<body>
    <h2>Student List</h2>
    <a href="../main.php">Back to Main</a><br><br>
    <a href="../pages/student_add.php">Add New Student</a><br><br>
    <table border="1">
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Course</th>
            <th>Actions</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['student_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['course']; ?></td>
            <td>
                <a href="../pages/student_edit.php?id=<?php echo $row['student_id']; ?>">Edit</a> |
                <a href="../pages/student_delete.php?id=<?php echo $row['student_id']; ?>" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
        </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>