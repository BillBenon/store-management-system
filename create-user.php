<?php
session_start();
if (!($_SESSION['userId'])) {
    header("location: login.php");
}
if ($_SESSION['roleId'] != 1) {
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New User</title>
    <link rel="stylesheet" href="index.css">
    <style>
        .error {
            color: crimson;
            text-align: center;
            font-size: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <?php
    require('connection.php');
    $error = "";
    if (isset($_POST['submit'])) {

        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $firstName = test_input($_POST['firstName']);
        $lastName = test_input($_POST['lastName']);
        $email = test_input($_POST['email']);
        $tel = test_input($_POST['tel']);
        $nationality = test_input($_POST['nationality']);
        $role = test_input($_POST['role']);

        if (!empty($_POST['gender'])) {
            $gender = $_POST['gender'];
        } else {
            $gender = "";
        }

        $username = test_input($_POST['username']);
        $password = test_input($_POST['password']);
        $cpassword = test_input($_POST['cpassword']);

        if (empty($firstName) || empty($lastName) || empty($lastName) || empty($email) || empty($tel) || empty($nationality) || empty($role) || empty($gender) || empty($username) || empty($password) || empty($cpassword)) {
            $error = "*All fields are required!*";
        } else if (strlen($firstName) < 4 || strlen($firstName) > 100) {
            $error = "*FirstName must be 4 minimum and 100 maximum characters*";
        } else if (strlen($lastName) < 4 || strlen($lastName) > 100) {
            $error = "*LastName must be 4 minimum and 100 maximum characters*";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "*Invalid email format*";
        } else if ($password != $cpassword) {
            $error = "*Passwords don't match*";
        } else if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $password)) {
            $error = "*Password must be atleast 8 alphanumeric characters*";
        } else if (!preg_match('/^(\+|(\+[1-9])?[0-9]*)*$/', $tel)) {
            $error = "*Invalid phone numbers*";
        } else if (mysqli_num_rows(mysqli_query($connection, "SELECT * FROM stk_users WHERE username='$username' AND email='$email'")) > 0) {
            $error = "User with the same email and username already exists!";
        } else {
            if (empty($error)) {
                $pass = hash('SHA512', $password);
                $sql = "INSERT INTO stk_users(firstName,lastName,telephone,gender,nationality, roleId,username,email,password) VALUES('$firstName','$lastName','$tel','$gender','$nationality', '$role','$username','$email','$pass')";
                $insertQuery = mysqli_query($connection, $sql);
                if ($insertQuery) {
                    echo "<h3>Registered User Successfully!</h3>";
                    header("location: display-users.php");
                } else {
                    echo "ERROR" . mysqli_connect_error();
                }
            }
        }
    }
    ?>

    <div class="all-content">
        <div class="main">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                <p><a href="javascript:history.go(-1)">Previous</a></p>
                <div class="form-header">
                    <h1>Create User</h1>
                    <hr>
                    <p class="error"><?= $error; ?></p>
                </div>
                <div class="row">
                    <label for="fname">FirstName</label>
                    <input type="text" name="firstName" id="fname" placeholder="Enter First Name">
                </div>
                <div class="row">
                    <label for="lname">LastName</label>
                    <input type="text" name="lastName" id="lname" placeholder="Enter Last Name">
                </div>
                <div class="row">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email">
                </div>
                <div class="row">
                    <label for="tel">Telephone</label>
                    <input type="tel" name="tel" id="tel" placeholder="Enter Telephone Number">
                </div>
                <div class="row gender">
                    <label for="gender">Gender</label>
                    <input type="radio" name="gender" id="male" value="male">
                    <label for="male">Male</label>
                    <input type="radio" name="gender" id="female" value="female">
                    <label for="female">Female</label>
                </div>
                <div class="row">
                    <label for="nationality">Nationality</label>
                    <select name="nationality" id="nationality">
                        <?php
                        require('connection.php');
                        $countriesSelectQuery = mysqli_query($connection, "SELECT * from countries");
                        if ($countriesSelectQuery) {
                        ?>
                            <option value="">--Select--</option>
                            <?php
                            while ($row = mysqli_fetch_assoc($countriesSelectQuery)) { ?>
                                <option value=<?= $row["countryId"] ?>><?= $row["countryName"] ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <label for="role" id="role">Role</label>
                    <select name="role" id="role">
                        <?php
                        $roleSelectQuery = mysqli_query($connection, "SELECT * from roles");
                        if ($roleSelectQuery) {
                        ?>
                            <option value="">--Select--</option>
                            <?php
                            while ($row = mysqli_fetch_assoc($roleSelectQuery)) { ?>
                                <option value=<?= $row["roleId"] ?>><?= $row["roleName"] ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Enter User Name">
                </div>
                <div class="row">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter Your Password">
                </div>
                <div class="row">
                    <label for="cpassword">Confirm Password</label>
                    <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Your Password">
                </div>
                <div class="submit">
                    <input type="submit" name="submit" value="Register">
                </div>
            </form>
        </div>
        <div class="footer">
            <p>Copyright 2021 &copy; Bill-Trezor | All rights reserved.</p>
        </div>
    </div>
</body>

</html>