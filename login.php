<?php
session_start();
if (!(empty($_SESSION))) {
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        $username = test_input($_POST['username']);
        $password = test_input($_POST['password']);

        if (empty($username) || empty($password)) {
            $error = "*All fields are required!*";
        } else if (strlen($username) < 4 || strlen($username) > 100) {
            $error = "*Username or email must be 4 minimum and 100 maximum characters*";
        } else if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $password)) {
            $error = "*Password must be atleast 8 alphanumeric characters*";
        } else {
            if (empty($error)) {
                $pass = hash('SHA512', $password);
                $sql = "SELECT * FROM stk_users WHERE username='" . $username . "' OR email='" . $username . "' AND password = '" . $pass . "'";
                $findUserQuery = mysqli_query($connection, $sql);
                if ($findUserQuery) {
                    if (mysqli_num_rows($findUserQuery) > 0) {
                        // echo "<h3>User found!</h3>";
                        while ($rows = mysqli_fetch_assoc($findUserQuery)) {
                            $_SESSION['userId'] = $rows["userId"];
                            $_SESSION['username'] = $rows["username"];
                            $_SESSION['roleId'] = $rows["roleId"];
                            $_SESSION['lastName'] = $rows["lastName"];
                            $_SESSION['firstName'] = $rows["firstName"];
                            $_SESSION['gender'] = $rows["gender"];
                            $_SESSION['email'] = $rows["email"];
                            $_SESSION['telephone'] = $rows["telephone"];
                            $_SESSION['roleId'] = $rows["roleId"];
                        }
                        $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        function getBrowser()
                        {
                            global $user_agent;
                            $arr_browsers = ["Opera", "Edg", "Chrome", "Safari", "Firefox", "MSIE", "Trident"];
                            foreach ($arr_browsers as $browser) {
                                if (strpos($user_agent, $browser) !== false) {
                                    $user_browser = $browser;
                                    break;
                                }
                            }
                            switch ($user_browser) {
                                case 'Trident':
                                    $user_browser = 'Internet Explorer';
                                    break;
                                case 'MSIE':
                                    $user_browser = 'Internet Explorer';
                                    break;
                                case 'Edg':
                                    $user_browser = 'Microsoft Edge';
                                    break;
                            }
                            return $user_browser;
                        }
                        function getOS()
                        {
                            global $user_agent;
                            $os_platform  = "Unknown OS Platform";
                            $os_array     = array(
                                '/windows nt 10/i'      =>  'Windows 10',
                                '/windows nt 6.3/i'     =>  'Windows 8.1',
                                '/windows nt 6.2/i'     =>  'Windows 8',
                                '/windows nt 6.1/i'     =>  'Windows 7',
                                '/windows nt 6.0/i'     =>  'Windows Vista',
                                '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                                '/windows nt 5.1/i'     =>  'Windows XP',
                                '/windows xp/i'         =>  'Windows XP',
                                '/windows nt 5.0/i'     =>  'Windows 2000',
                                '/windows me/i'         =>  'Windows ME',
                                '/win98/i'              =>  'Windows 98',
                                '/win95/i'              =>  'Windows 95',
                                '/win16/i'              =>  'Windows 3.11',
                                '/macintosh|mac os x/i' =>  'Mac OS X',
                                '/mac_powerpc/i'        =>  'Mac OS 9',
                                '/linux/i'              =>  'Linux',
                                '/ubuntu/i'             =>  'Ubuntu',
                                '/iphone/i'             =>  'iPhone',
                                '/ipod/i'               =>  'iPod',
                                '/ipad/i'               =>  'iPad',
                                '/android/i'            =>  'Android',
                                '/blackberry/i'         =>  'BlackBerry',
                                '/webos/i'              =>  'Mobile'
                            );
                            foreach ($os_array as $regex => $value)
                                if (preg_match($regex, $user_agent))
                                    $os_platform = $value;
                            return $os_platform;
                        }

                        $mac = strtok(exec('getmac'), ' ');
                        $ip = getHostByName(gethostname());
                        $os = getOs();
                        $browser = getBrowser();
                        if (mysqli_query($connection, "INSERT INTO auth_user_info(userId, mac_address, ip_address, OS, Browser) VALUES (" . $_SESSION["userId"] . ", '$mac', '$ip', '$os', '$browser')")) {
                            header("location: index.php?userId=" . $_SESSION['userId'] . "");
                        } else {
                            $error = "*An error occurred! Login again*";
                        }
                        // header("location: index.php?userId=" . $_SESSION['userId'] . "");
                    } else {
                        $error = "*Username or Password is wrong!";
                    }
                } else {
                    echo "ERROR" . mysqli_connect_error();
                }
                // biBE1@
            }
        }
    }
    ?>

    <div class="all-content">
        <div class="main">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                <div class="form-header">
                    <p style="font-size: 150%; text-align: left;"><a href="javascript:history.go(-1)">Back</a></p>
                    <h1>Login</h1>
                    <hr>
                    <p class="error"><?= $error; ?></p>
                </div>
                <div class="row">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Userame/Email">
                </div>
                <div class="row">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password">
                </div>
                <div class="submit">
                    <input type="submit" name="submit" value="Login">
                </div>
            </form>
        </div>
        <div class="footer">
            <p>Copyright 2021 &copy; Bill-Trezor | All rights reserved.</p>
        </div>
    </div>
</body>

</html>