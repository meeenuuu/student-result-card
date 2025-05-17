<?php
include 'db.php'; // make sure db.php connects to your MySQL database
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Result Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f2f2f2;
        }
        h2 {
            color: #333;
        }
        table {
            border-collapse: collapse;
            width: 60%;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #f9f9f9;
        }
        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>Search Student Result</h2>
    <form method="GET" action="">
        <input type="text" name="roll" placeholder="Enter Roll Number" required>
        <input type="submit" value="Search">
    </form>

    <?php
    if (isset($_GET['roll'])) {
        $roll = $_GET['roll'];
        $query = "SELECT * FROM students_results WHERE roll_number = '$roll'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $subjects = [];
            $student_name = '';
            $exam_date = '';

            while ($row = mysqli_fetch_assoc($result)) {
                $student_name = $row['student_name'];
                $exam_date = $row['exam_date'];
                $subjects[] = [
                    'subject' => $row['subject'],
                    'marks' => $row['marks'],
                    'grade' => $row['grade']
                ];
            }

            echo "<h3>Result Card</h3>";
            echo "<p><strong>Name:</strong> $student_name</p>";
            echo "<p><strong>Roll Number:</strong> $roll</p>";
            echo "<p><strong>Exam Date:</strong> $exam_date</p>";

            echo "<table>";
            echo "<tr><th>Subject</th><th>Marks</th><th>Grade</th></tr>";
            foreach ($subjects as $subject) {
                echo "<tr>
                    <td>{$subject['subject']}</td>
                    <td>{$subject['marks']}</td>
                    <td>{$subject['grade']}</td>
                </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No results found for Roll Number: $roll</p>";
        }
    }
    ?>
</body>
</html>
