<?php
session_start();
if (!($_SESSION['userId'])) {
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User Account</title>
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
    define("USERID", $_GET["thisID"]);
    $sql = "SELECT us.firstName, us.lastName, us.telephone, us.gender,us.nationality as nationId, ctr.countryName as nationality, rl.roleId, rl.roleName FROM countries ctr JOIN stk_users us ON us.nationality=ctr.countryId JOIN roles rl ON us.roleId=rl.roleId WHERE us.userId=" . USERID . "";
    $query = mysqli_query($connection, $sql);
    $error = "";
    if (isset($_POST['submit'])) {
        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $tel = $_POST['tel'];
        $nationality = $_POST['nationality'];
        $role = test_input($_POST['role']);
        $gender = $_POST['gender'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

        if (empty($firstName) || empty($lastName) || empty($lastName) || empty($tel) || empty($nationality) || empty($role) || empty($gender) || empty($password) || empty($cpassword)) {
            $error = "*All fields are required!*";
        } else if (strlen($firstName) < 4 || strlen($firstName) > 100) {
            $error = "*FirstName must be 4 minimum and 100 maximum characters*";
        } else if (strlen($lastName) < 4 || strlen($lastName) > 100) {
            $error = "*LastName must be 4 minimum and 100 maximum characters*";
        } else if ($password != $cpassword) {
            $error = "*Passwords don't match*";
        } else if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $password)) {
            $error = "*Password must be atleast 8 alphanumeric characters*";
        } else if (!preg_match('/^(\+|(\+[1-9])?[0-9]*)*$/', $tel)) {
            $error = "*Invalid phone numbers*";
        } else {
            if (empty($error)) {
                $pass = hash('SHA512', $password);
                $sql = "UPDATE stk_users SET firstName='$firstName',lastName='$lastName',telephone='$tel',gender='$gender',nationality='$nationality',password='$pass' WHERE userId=" . USERID . "";
                $updateQuery = mysqli_query($connection, $sql);
                if ($updateQuery) {
                    echo "<h3>Updated User Successfully!</h3>";
                    header("location: display-users.php");
                } else {
                    echo "ERROR" . mysqli_connect_error();
                }
            }
        }
    }
    while ($row = mysqli_fetch_assoc($query)) { ?>

        <div class="all-content">
            <div class="main">
                <!-- action.php?action=update-user -->
                <form action="useredit.php?thisID=<?= USERID ?>" method="POST" enctype="multipart/form-data">
                    <p><a href="javascript:history.go(-1)">Previous</a></p>
                    <div class="form-header">
                        <h1>Update User</h1>
                        <hr>
                        <p class="error"><?= $error; ?></p>
                    </div>
                    <input type="hidden" name="thisID" value="<?= USERID ?>">
                    <div class="row">
                        <label for="fname">FirstName</label>
                        <input type="text" name="firstName" id="fname" placeholder="Enter First Name" required value="<?= $row["firstName"] ?>">
                    </div>
                    <div class="row">
                        <label for="lname">LastName</label>
                        <input type="text" name="lastName" id="lname" placeholder="Enter Last Name" required value="<?= $row["lastName"] ?>">
                    </div>
                    <div class="row">
                        <label for="tel">Telephone</label>
                        <input type="tel" name="tel" id="tel" placeholder="Enter Telephone Number" minlength="10" maxlength="15" pattern='(\+|(\+[1-9])?[0-9]*)' maxlength="15" minlength="10" required value="<?= $row["telephone"] ?>" title="should be composed of + and numbers only with a maximum of 15 and minimum of 10">
                    </div>
                    <div class="row gender">
                        <label for="gender">Gender</label>
                        <input type="radio" name="gender" id="male" value="male" required <?php if ($row["gender"] == 'male') {
                                                                                                echo "checked";
                                                                                            } ?>>
                        <label for="male">Male</label>
                        <input type="radio" name="gender" id="female" value="female" required <?php if ($row["gender"] == 'female') {
                                                                                                    echo "checked";
                                                                                                } ?>>
                        <label for="female">Female</label>
                    </div>
                    <div class="row">
                        <label for="nationality">Nationality</label>
                        <select name="nationality" id="nationality" required>
                            <option value="<?= $row["nationId"] ?>"><?= $row["nationality"] ?></option>
                            <?php
                            $initialCtr = $row["nationId"];
                            $otherCtrquery = mysqli_query($connection, "SELECT * FROM countries WHERE countryId != '$initialCtr'");
                            while ($otherCtr = mysqli_fetch_assoc($otherCtrquery)) { ?>
                                <option value="<?= $otherCtr["countryId"] ?>"><?= $otherCtr["countryName"] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="row">
                        <label for="role" id="role">Role</label>
                        <select name="role" id="role" required>
                            <option value="<?= $row["roleId"] ?>"><?= $row["roleName"] ?></option>
                            <?php
                            $initialCtr = $row["roleId"];
                            $otherCtrquery = mysqli_query($connection, "SELECT * FROM roles WHERE roleId != '$initialCtr'");
                            while ($otherCtr = mysqli_fetch_assoc($otherCtrquery)) { ?>
                                <option value="<?= $otherCtr["roleId"] ?>"><?= $otherCtr["role"] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="row">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter Your Password" required>
                    </div>
                    <div class="row">
                        <label for="cpassword">Confirm Password</label>
                        <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Your Password" required>
                    </div>
                    <div class="submit">
                        <input type="submit" name="submit" value="Update User">
                    </div>
                </form>
            </div>
            <div class="footer">
                <p>Copyright 2021 &copy; Bill-Trezor | All rights reserved.</p>
            </div>
        </div>
    <?php
    }
    ?>
</body>

</html>