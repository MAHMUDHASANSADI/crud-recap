<?php
include 'configure.php';

if (isset($_POST['submit'])) {
    // Retrieve user inputs
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Use a prepared statement to prevent SQL injection
    $sql = "INSERT INTO users (firstname, lastname, email, password, gender) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $hashed_password, $gender);

        // Execute the query
        if ($stmt->execute()) {
            echo 'Record created successfully';
        } else {
            echo 'Error: ' . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo 'Error: ' . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<body>
<form action="create.php" method="POST">
    <input type="text" name="firstname" placeholder="First Name" required>
    <input type="text" name="lastname" placeholder="Last Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <select name="gender" required>
        <option value="male">Male</option>
        <option value="female">Female</option>
    </select>
    <button type="submit" name="submit">Submit</button>
</form>
</body>
</html>
