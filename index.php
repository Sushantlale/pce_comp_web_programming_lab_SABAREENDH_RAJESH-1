<?php
session_start(); // Start session (ensure this is at the beginning of your script)

$servername = "localhost";
$db_username = "root"; // Default username for XAMPP MySQL
$db_password = ""; // Default password for XAMPP MySQL
$dbname = "login page"; // Your database name

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted for sign-up
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signupbtn'])) {
    // Retrieve username, email, and password from the form
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Perform basic validation (you can add more robust validation)
    if (!empty($username) && !empty($email) && !empty($password)) {
        // Prepare a SQL statement to insert user data into the database
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to a success page upon successful sign up
            header("Location: signup_success.php");
            exit;
        } else {
            // If there's an error, display an error message
            $error_message = "Error signing up. Please try again.";
        }
    } else {
        // If any field is empty, display an error message
        $error_message = "Username, email, and password are required.";
    }
}

// Check if the form is submitted for sign-in
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signinbtn'])) {
    // Retrieve username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // In a real-world scenario, you would validate the username and password against a database
    // For demonstration purposes, let's assume valid credentials are "admin" and "password123"
    $valid_username = "admin";
    $valid_password = "password123";

    // Check if the provided credentials match the valid ones
    if ($username === $valid_username && $password === $valid_password) {
        // Redirect to a dashboard or home page upon successful login
        header("Location: dashboard.php");
        exit;
    } else {
        // If credentials are incorrect, set a session variable
        $_SESSION["login_error"] = true;
        // Redirect back to the login page
        header("Location: login.php");
        exit;
    }
}
?>



<script>
    // Check if the session variable is set and display the alert
    <?php if (isset($_SESSION["login_error"])): ?>
        alert("Invalid username or password. Please try again.");
        <?php unset($_SESSION["login_error"]); ?>
    <?php endif; ?>
</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>LANDING PAGE</title>
    <script src="https://kit.fontawesome.com/c1918dbe9d.js" crossorigin="anonymous"></script>
</head>

<body>


    <nav class="navbar">
        <label class="logo">ReSure</label>
        <ul class="normal">
            <li><a href="#">HOME</a></li>
            <li><a href="about.html">ABOUT</a></li>
            <li><a href="#">HELP</a></li>
            <li><a href="#">FEEDBACK</a></li>

            <li>
                <input class="label-check" id="label-check" type="checkbox">
                <label for="label-check" class="hamburger-label">
                    <div class="line1"></div>
                    <div class="line2"></div>
                    <div class="line3"></div>

                </label>
            </li>
        </ul>
        <ul class="home-menu">
            <li><a href="#">HOME</a></li>
            <li><a href="#">ABOUT</a></li>
            <li><a href="#">HELP</a></li>
            <li><a href="#">FEEDBACK</a></li>
        </ul>


    </nav>
    <footer class="f">
        <p>"@ALL RIGHTS THE RESERVED TO RESEURE PVT.LTD"</p>
    </footer>
    <div class="content">
        <div class="form-box">
            <h1 id="title">Sign Up</h1>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="inputgroup">
                    <div class="input-field" id="namefield">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" placeholder="Name">

                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" placeholder="Email">

                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" placeholder="Password">
                    </div>
                    <p>Lost Password?<a href="#">Click Here</a></p>
                </div>
                <div class="btn-fld">
                    <button type="button" id="signupbtn">Sign Up</button>
                    <button type="button" id="signinbtn" class="disable">Sign In</button>
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let signupbtn = document.getElementById("signupbtn");
        let signinbtn = document.getElementById("signinbtn");
        let namefield = document.getElementById("namefield");
        let title = document.getElementById("title");

        signinbtn.onclick = function () {
            namefield.style.maxHeight = "0";
            title.innerHTML = "Sign In";
            signupbtn.classList.add("disable");
            signinbtn.classList.remove("disable");
        }

        signupbtn.onclick = function () {
            namefield.style.maxHeight = "60px";
            title.innerHTML = "Sign In";
            signupbtn.classList.remove("disable");
            signinbtn.classList.add("disable");
        }

    </script>



</body>

</html>