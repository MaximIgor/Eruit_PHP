<?php
include_once('includes/config_mssql.php');
$loginpageJS_CSS_Source = 'http://'.$_SERVER['HTTP_HOST'].'/my_eruit/';
// if(IsLoggedIn()) {
	// @header('location:'.HTTP_PATH.'home');
// }
if($lang=='en') {
	$cssSrc='ltr';
} else {
	$cssSrc='rtl';
}


if(!empty($_POST)) {
	// $checkRecord = $db_MYSQL->db_select("users",array("*"),"WHERE Username='".sanitizepostdata($_POST['Username'])."' AND Password='".sanitizepostdata($_POST['Password'])."'");
	// if($checkRecord && count($checkRecord)>0) {
		// $_SESSION['User']['ID'] = $checkRecord[0]->UserId;
		// $_SESSION['User']['Username'] = $checkRecord[0]->Username;
        
        if($_POST['Username'] == 'admin' && $_POST['Password'] == 'eruit'){
            $_SESSION['User']['ID'] = 1;
            $_SESSION['User']['Username'] = `revenger`;
            
            // echo "<pre>";
            // var_dump(HTTP_PATH);
            // echo "</pre>";
            @header('location:'.'index.php');

        }

		// if($checkRecord[0]->ConnStr != "") {
		// 	connectToDatabase($checkRecord[0]->ConnStr);
		// }
	// } 
    else {
		addScriptForExec('$.fn.alertUser("Invalid Username or Password.");');	
	}
}
?>
<!DOCTYPE html>
<html lang="<?=$lang?>">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <base href="<?=HTTP_PATH?>">
    <title>
        <?=PAGE_TITLE?> :: LOGIN
    </title>
    <link rel="stylesheet" href="<?=$loginpageJS_CSS_Source?>css/<?=$cssSrc?>.css">
    <script type="text/javascript" src="<?=$loginpageJS_CSS_Source?>js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="<?=$loginpageJS_CSS_Source?>js/noty/packaged/jquery.noty.packaged.js"></script>
    <script type="text/javascript" src="<?=$loginpageJS_CSS_Source?>js/formvalidator.js"></script>
</head>
<style>
    * {
        margin: 0px;
    }

    .login_logo {
        width: 1895px;
        height: 53px;
        background-color: #32353c;
        padding-left: 25px;
    }

    .user_block {
        width: 100vw;
        height: 866px;
        background-image: url(<?=$CURRENT_URL?>img/logo1.png);
        background-size: cover;
        background-color: black;
        display: flex;
    }

    .login_modal {
        /* width: 939px;
        height: 643px;
        background-color: #32353c9d; */
        margin-top: 120px;
    }

    .first_imgae {
        width: 30vw;
    }

    .third_imgae {
        width: 30vw;
    }


    /* login modal*/

    .container {
        width: 700px;
        height: 500px;
        background-color: #000000d2;
        /* margin-top: 120px; */
        /* Slightly lighter background */
        border-radius: 8px;
        padding: 30px;
        /* width: 400px; */
        box-shadow: 0px 0px 0px 1px rgba(255, 255, 255, 0.795);
        /* Subtle Shadow */
        position: relative;
        /* For the close button */
    }

    .close-button {
        position: absolute;
        top: 1px;
        right: 25px;
        font-size: 24px;
        color: #fff;
        text-decoration: none;
        cursor: pointer;
    }

    .close-button:hover {
        color: #ccc;
        /* Slightly lighter on hover */
    }

    /* h2 {
        margin-bottom: 20px;
    } */

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #a0a0a0;
    }

    input[type="text"],
    input[type="password"] {
        width: 80%;
        /* width: 772px; */
        height: 58px;
        padding: 12px;
        border: 1px solid #444;
        /* Darker Border */
        background-color: #333;
        /* Even Darker Input Background */
        color: #fff;
        border-radius: 4px;
        box-sizing: border-box;
        /* Include padding and border in element's total width/height */
        transition: border-color 0.2s ease;
        /* Smooth transition */
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
        border-color: #007bff;
        /* Highlight on Focus */
        outline: none;
        /* Remove default focus outline */
    }

    .checkbox-group {
        display: flex;
        align-items: center;
    }

    input[type="checkbox"] {
        margin-right: 8px;
    }

    .login_button {
        background-color: #007bff;
        /* Primary Button Color */
        color: #fff;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 80%;
        font-size: 16px;
        transition: background-color 0.2s ease;
        /* Smooth transition */
    }

    .login_button :hover {
        background-color: #0056b3;
        /* Darker on Hover */
    }

    a {
        color: #aaa;
        text-decoration: none;
        display: block;
        text-align: center;
        margin-top: 15px;
    }

    a:hover {
        color: #fff;
    }

    /* Decorative Elements */
    .decorative-element {
        position: absolute;
        bottom: 20px;
        right: 20px;
        width: 80px;
        height: 80px;
        /* Customize the decorative element here.  You could use an image,
               a CSS-created shape, or a simple line drawing.
            */
        /* Example: Simple heart shape using before and after pseudo-elements */
        /*
            border: 1px solid #888;
            border-radius: 50%;
            background: linear-gradient(to bottom right, transparent 50%, #888 50%), linear-gradient(to bottom left, transparent 50%, #888 50%);
            background-size: 50% 100%;
            background-position: 0 50%, 100% 50%;
            background-repeat: no-repeat;
            */
    }

    .heart {
        position: absolute;
        background-image: url(<?=$CURRENT_URL?>img/logo2.png);
        background-size: auto;
        /* bottom: 20px;
        right: 20px;
        width: 80px;
        height: 80px; */
    }

    /* .heart::before,
    .heart::after {
        position: absolute;
        content: "";
        width: 50px;
        height: 80px;
        background: #888;
        border-radius: 50px 50px 0 0;
    }

    .heart::before {
        left: 40px;
        transform: rotate(-45deg);
        transform-origin: 0 100%;
    }

    .heart::after {
        left: 0;
        transform: rotate(45deg);
        transform-origin: 100% 100%;
    } */

    #modal_title {
        font-family: 'Noto Sans';
        font-size: 40px;
        color: white;
        text-align: center;

    }

    #modal_content {
        font-family: 'Noto Sans';
        font-size: 20px;
        color: #505050;
        text-align: center;

    }

    #loginFormID {
        width: 90%;
        padding-left: 95px;
    }
</style>

<body>
    <div id="main">
        <div class="header">
            <div class="login_logo">
                <img width="74px" height="24.7px" style="padding-top: 15px;" src="<?=$CURRENT_URL?>img/logo.png"
                    alt="login_logo">
            </div>
        </div>

        <div class="user_block">
            <div class="first_imgae" >
                <img src="<?=$CURRENT_URL?>img/logo3.png" alt="">
            </div>
            <div class="login_modal">

                <div class="container">
                    <!-- <a href="<?=$CURRENT_URL?>" class="close-button">×</a> -->
                    <h2 id="modal_title">Welcome!</h2><br>
                    <p id="modal_content">Sign up for Eruit</p>
                    <form name="loginForm" class="formArea" id="loginFormID" action="<?=$CURRENT_URL?>" method="post">


                        <div class="form-group">
                            <label for="username">USERNAME</label>
                            <input name="Username" type="text" id="username" class="textbox required" value="">
                            <!-- <input type="text" id="username"   name="username"> -->
                        </div>

                        <div class="form-group">
                            <label for="password">PASSWORD</label>
                            <input name="Password" type="password" class="textbox required" value="" id="password">

                            <!-- <input type="password" id="password" name="password"> -->
                        </div>

                        <div class="form-group checkbox-group">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">REMEMBER ME</label>
                        </div>
                        <input type="submit" value="SIGN IN" name="saveBut" class="button login_button">
                        <div style="text-align: left;align-items: left;display: flex; padding-top: 15px;">
                            <a href="<?=$CURRENT_URL?>">
                                <p style="color:#4290F2;  text-decoration: underline;">HELP I CAN'T SIGN IN</p>
                            </a>
                        </div>

                    </form>

                </div>


                <!-- <div class="user_details">
                    <form name="loginForm" class="formArea" id="loginFormID" action="<?=$CURRENT_URL?>" method="post">
                        <label for="username">Username</label>
                        <input name="Username" type="text" class="textbox required" value="">
                        <label for="password">Password</label>
                        <input name="Password" type="password" class="textbox required" value="">
                        <input type="submit" value="Login" name="saveBut" class="button">
                    </form>
                </div> -->
            </div>
            <div class="third_imgae" style="padding: 250px 0px 0px 50px;">
                <img src="<?=$CURRENT_URL?>img/logo3.png" alt="">
            </div>
        </div>
    </div>
    <?=executeScriptAfterPageLoad();?>
</body>

</html>