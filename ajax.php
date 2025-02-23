<?php
	include_once('php/db.php');
	$mode 	= $_POST['mode'];
	// $db 	= new DBAccess();
	$uid 	= $_SESSION['User']['ID'];
	// $max_countRes = $db->get_info_arr("users","UserId='".$uid."'");
	switch ($mode)
	{
		case 'create_project':
			$arr 	= $db->get_info_arr("tbl_project","title='".$_POST['title']."' AND user_id='".$uid."'");
			$max_countRes = $db->get_info_arr("users","UserId='".$uid."'");
			if(count($max_countRes)>0) {
				$max_count = $max_countRes[0]['max_projects'];
			} else {
				$max_count = 99;
			}
			
			$my_arr 	= $db->get_info_arr("tbl_project","user_id='".$uid."'");
			if(count($arr) > 0) 
			{
				echo "-1";
				return;
			}
			if(count($my_arr) > $max_count) 
			{
				echo "-2";
				return;
			}
			$sql  = "INSERT INTO tbl_project SET ";
			$sql .= " user_id='".$uid."'";
			$sql .= ", title='".$_POST['title']."'";
			$sql .= ", descr='".$_POST['descr']."'";
			$sql .= ", data='".$_POST['data']."'";

			$db->run_sql($sql);

			echo mysql_insert_id();
			break;

		case 'append_object':
			
			$id_arr 	= explode(",", $_POST['data']);

			for($i = 0; $i < count($id_arr); $i++)
			{
				if($id_arr[$i] == "") continue;

				$sql  = "INSERT INTO objects (name, user_id, two_obj, three_obj, three_mtl, thumb_img, size, descr) ";
				$sql .= "SELECT name, '".$uid."', two_obj, three_obj, three_mtl, thumb_img, size, descr FROM objects ";
				$sql .= "WHERE id = ".$id_arr[$i];

				$db->run_sql($sql);
			}

			break;

		case 'create_object':
			
			$data_arr 	= explode(",", $_POST['data']);
			$dir 		= $data_arr[4];
			// $mtls 		= explode(";",$data_arr[7]);

			// if(file_exists("objs/".$dir))
			// {
			// 	$ret_arr['mode'] 	= 'error';
			// 	$ret_arr['msg'] 	= 'The name is already exist, Please input another name!';
				
			// 	echo json_encode($ret_arr);
			// 	return;
			// }
			// map.png,White_chir.jpeg,Chir_whiteMap.obj,Chir_whiteMap.mtl,asdfasf,4,4


			$dbhost = 'localhost';
			$dbname = 'floor';
			$username = 'root';
			$password = '';

			$conn = new mysqli($dbhost, $username, $password, $dbname);
			// $sql = "INSERT INTO users (user_id, thumb_img, two_obj,three_obj, three_mtl, name, size)
			// VALUES ($uid, $data_arr[0], $data_arr[1], $data_arr[2],$data_arr[3], $data_arr[4], $data_arr[5].$data_arr[6])";

			$sql  = "INSERT INTO objects SET ";
			$sql .= " user_id='".$uid."'";
			$sql .= ", thumb_img='".$data_arr[0]."'";
			$sql .= ", two_obj='".$data_arr[1]."'";
			$sql .= ", three_obj='".$data_arr[2]."'";
			$sql .= ", three_mtl='".$data_arr[3]."'";
			$sql .= ", name='".$data_arr[4]."'";
			$sql .= ", size='".$data_arr[5].",".$data_arr[6]."'";
			
			$conn->query($sql);
			// $db->run_sql($sql);

			// mkdir("objs/".$dir);
			
			// rename("tmp/".$data_arr[0],"objs/".$dir."/".$data_arr[0]);
			// rename("tmp/".$data_arr[1],"objs/".$dir."/".$data_arr[1]);
			// rename("tmp/".$data_arr[2],"objs/".$dir."/".$data_arr[2]);
			// rename("tmp/".$data_arr[3],"objs/".$dir."/".$data_arr[3]);

			// for($i = 0; $i < count($mtls); $i++)		
			// {
			// 	if($mtls[$i] == "" || $mtls[$i] == null || $mtls[$i] == "null") 
			// 		continue;

			// 	rename("tmp/".$mtls[$i],"objs/".$dir."/".$mtls[$i]);
			// }

			$ret_arr['mode'] 	= 'success';
			$ret_arr['msg'] 	=`Unknown ERROR!`;
			
			echo json_encode($ret_arr);
			break;

		case "get_projectlist":

			$html 	= "";

			$arr 	= $db->get_info_arr("tbl_project","user_id='".$uid."'");
			$proID 	= $_POST['proID'];


			for($i = 0; $i < count($arr); $i++)
			{
				if($proID && $proID == $arr[$i]['id'])
					$html .= "<option value='".$arr[$i]['id']."' update='".$arr[$i]['last_update']."' descr='".$arr[$i]['descr']."' data='".$arr[$i]['data']."' selected>".$arr[$i]['title']."</option>";
				else
					$html .= "<option value='".$arr[$i]['id']."' update='".$arr[$i]['last_update']."' descr='".$arr[$i]['descr']."' data='".$arr[$i]['data']."'>".$arr[$i]['title']."</option>";
			}



			echo $html;

		break;


		case "update_project":

			$sql  = "UPDATE tbl_project SET";
			$sql .= " data='".$_POST['data']."'";
			$sql .= " WHERE id=".$_POST['proID'];

			$db->run_sql($sql);

		break;

		case "delete_project":

			$arr  = $db->get_info_arr("objects","name='".$_REQUEST['name']."' AND user_id=0");

			if(count($arr) > 1)
			{
				$sql  = "DELETE FROM objects WHERE id=".$_REQUEST['id'];
			}
			else
			{
				$sql  = "UPDATE objects SET";
				$sql .= " user_id = 0";
				$sql .= " WHERE id=".$_REQUEST['id'];
			}

			$db->run_sql($sql);

			echo "success";

		break;

		

		default:

			# code...

			break;

	}

?>