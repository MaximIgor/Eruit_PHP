<?php
    error_reporting(E_ALL);

    // ini_set('max_execution_time', 18000);
    // ini_set("memory_limit","202M");
    // ini_set("time_limit","5555");
    // ini_set("post_max_size","2001M");
    // ini_set("upload_max_filesize","2000M");

	session_start();

	include_once(__DIR__."/php/config.php");
    include_once(__DIR__."/includes/dbClass.php");

	define("DB_HOST",IP_ADDR);
	define("DB_USER",USER_NAME);
	define("DB_PASSWORD",USER_PASS);
	define("DB_CHARSET","utf8");

	$db = new dbClass();

    
    // $_SESSION['User']['ID'] = 1;
    
    // $info = $db->db_select("objects",array("*"),"WHERE user_id='".$_SESSION['User']['ID']."'");
    $info = $db->db_select("objects",array("*"));

    $thumb_path = "";
    $obj_html   = "";
    $my_objs    = array();

	if($info && count($info)>0)
    {
		foreach($info as $eachInfo)
        {
            $thumb_path = "objs/".$eachInfo->name."/";
			$obj_html .= '<li name="'.$eachInfo->name.'" info="'.$eachInfo->id.'" tool="image" twod="'.$eachInfo->two_obj.'" title="'.$eachInfo->descr.'" thrd="'.$eachInfo->three_obj.'" size="'.$eachInfo->size.'">';
			$obj_html .= '<img src="'.$thumb_path.$eachInfo->thumb_img.'" /></li>';

            array_push($my_objs, $eachInfo->name);
		}
	}

    $all_obj    = $db->db_select("objects",array("*"));
    $all_html   = "";

    if($all_obj && count($all_obj)>0)
    {
        foreach($all_obj as $eachInfo)
        {
            $thumb_path = "objs/".$eachInfo->name."/";

            if(in_array($eachInfo->name, $my_objs)) continue;

            $all_html .= '<tr>';
            // $all_html .= '<td><input type="checkbox" info="'.$eachInfo->id.'"></td>';
            // $all_html .= '<td>'.$eachInfo->name.'</td>';
            // $all_html .= '<td><img src="'.$thumb_path.$eachInfo->thumb_img.'" /></td>';
            $all_html .= '</tr>';
        }
    }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>3D Floor Plan Editing Tool</title>

    <link rel="stylesheet" type="text/css" href="style/style.css" />
    <link rel="stylesheet" type="text/css" href="style/overlay.css" />
    <link rel="stylesheet" type="text/css" href="style/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="style/colorpicker.css" />
    <link rel="stylesheet" type="text/css" href="style/newStyle.css" />
    <link rel="stylesheet" type="text/css" href="style/tool.css" />
</head>

<script type="text/javascript" src="js/library/jquery.min.js"></script>
<script type="text/javascript" src="js/library/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/library/fabric.min.js"></script>
<script type="text/javascript" src="js/library/colorpicker.js"></script>

<script type="text/javascript" src="js/library/Three.js"></script>
<script type="text/javascript" src="js/library/Detector.js"></script>
<script type="text/javascript" src="js/library/Stats.js"></script>

<script type="text/javascript" src="js/library/MTLLoader.js"></script>
<script type="text/javascript" src="js/library/OBJMTLLoader.js"></script>
<script type="text/javascript" src="js/library/OrbitControls.js"></script>

<script src="js/library/file_upload/jquery.iframe-transport.js"></script>
<script src="js/library/file_upload/jquery.ui.widget.js"></script>
<script src="js/library/file_upload/jquery.fileupload.js"></script>

<script type="text/javascript" src="js/mine/common/addon.js"></script>
<script type="text/javascript" src="js/mine/common/main.js"></script>
<script type="text/javascript" src="js/mine/common/event.js"></script>
<script type="text/javascript" src="js/mine/common/popup.js"></script>
<script type="text/javascript" src="js/mine/drawing/draw.js"></script>
<script type="text/javascript" src="js/mine/3dmode/3ds.js"></script>

<body>

    <!-- <div id="top_area">
    	<a href="<?='http://'.$_SERVER['HTTP_HOST']?>">
        	<img src="img/logo.png">
        </a>
    </div> -->

    <div class="header">
        <div class="login_logo">
            <img width="74px" height="24.7px" style="padding-top: 15px;" src="img/logo.png" alt="login_logo">
        </div>
    </div>

    <!-- <div id="overlay"></div> -->
    <div id="over_overlay">
        <?php require_once(__DIR__."/theme/overlay.html"); ?>
    </div>

    <div id="area_2d">
        <div id="ctrl_area">
            <ul>
                <!-- <li><img src="img/book.gif"></li>
                <li><img src="img/folder.gif"></li>
                <li><img src="img/card.gif"></li>
                <li><img src="img/save_as.png"></li>
                <li><img src="img/fax.png"></li>
                <li class="spliter">&nbsp;</li>
                <li><img src="img/close.gif"></li>
                <li><img src="img/copy.gif"></li>
                <li class="spliter">&nbsp;</li>
                <li><img src="img/3D.gif"></li>
                <li class="spliter">&nbsp;</li>
                <li><img src="img/ring.gif"></li>
                <li><img src="img/star.gif"></li> -->


                <li><img src="img/new/book.png"></li>
                <li>&nbsp;</li>
                <li><img src="img/new/folder.png"></li>
                <li>&nbsp;</li>
                <li><img src="img/new/card.png"></li>
                <li>&nbsp;</li>
                <li><img src="img/new/copy.png"></li>
                <li class="spliter">&nbsp;</li>
                <li>&nbsp;</li>
                <li><img style="margin-top: 10px;" src="img/new/3D.png"></li>
                <li><img src="img/new/copy.png"></li>
                <li>&nbsp;</li>            
                <li class="spliter">&nbsp;</li>
                <li>&nbsp;</li>
                <li><img style="margin-top: 5px;" src="img/new/x.png"></li>
                <li class="spliter">&nbsp;</li>
                <li><img src="img/new/Group 5.png"></li>
                <li>&nbsp;</li>
                <li><img src="img/new/Group 6.png"></li>
            </ul>
        </div>


        <?php require_once(__DIR__."/theme/tool.html"); ?>
        



        <div id="canvas_area">
            <font color="red" id="font_protitle"></font>
            <center>Move here</center>
            <canvas id="canvas"></canvas>
            <div id="grid_bg"></div>
        </div>


        
        <!-- <div id="left_area">

            <div id="recycle_area"></div>

            <div id="left_slider"></div>
            <h2>Please select Objects:</h2>
            <div class="category" id="floorArea">

                <ul>

                     <?php echo $obj_html; ?> 

                    </li>

                </ul>

                <div class="clear_both"></div>

            </div> 

            <a id="btn_add_obj">Add new Object</a>

        </div> -->



        <img src="img/footer_label.png" id="footer_label">



        <div id="right_area">

            <div id="right_slider"></div>

            <h3>Properties</h3>

            <?php require_once("theme/property.html"); ?>

        </div>

        <div id="move_controlT">
            <center><img src="img/icon-arrow-down.png" /></center>
        </div>
        <div id="move_controlB">
            <center><img src="img/icon-arrow-projectlist.png" /></center>
        </div>
    </div>

    <div id="area_3d">
        <img src="img/close.png" id="img_close3d">
        <img src="img/btn_3d_export.png" id="export_3d">
    </div>
</body>