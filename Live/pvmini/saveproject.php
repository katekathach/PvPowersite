<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($path))
	$path = "";
require_once ('protected/properties.php');
?>
<?php
	// Get job (and id)
	$job = '';
	$userID = '';
	$id="";
	$system = "";
	$pjID;
	$isUpdate;
	if (isset($_GET['job'])) {
		$job = $_GET['job'];
		if ($job == 'get_projects' || $job == 'get_project' || $job == 'add_project' || $job == 'update_project' || $job == 'delete_project' || $job == 'check_project') {
			
			if (isset($_GET['id']) || isset($_GET['userid'])) {
				//$id = $_GET['id'];
				$userID = $_GET["userid"];
				
				$system = "pvmini";
				//echo $_GET["calcspan"];
				if (!is_numeric($id)) {
					$id = '';
				}
				
			}
			if(isset($_GET["id"])){
				$pjID = $_GET["id"];
			}
			if(isset($_GET["project_name"])){
				$projID = $_GET["project_name"];
			}
			if(isset($_GET["isupdate"])){
				$isUpdate = $_GET["isupdate"];
			}
			
		} else {
			$job = '';
		}
	}

	if ($job != "") {

		$db_connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (mysqli_connect_errno()) {
			$result = 'error';
			$message = 'Failed to connect to database: ' . mysqli_connect_error();
			$job = '';
		}

		function getExistingProjects($db_connection, $userID ,$system) {

			$sql = "SELECT `id`,`project_name`, `project_address`, `project_city` , `project_state` , `project_zip` FROM `powersite_project_data` WHERE `project_cust_id`=".
			 mysqli_real_escape_string($db_connection, (int)$userID) . " AND `project_system_id`=". "'$system'"   ;
			 $results_data = array();
			if ($query = mysqli_query($db_connection, $sql)) {
				while ($row = mysqli_fetch_assoc($query)) {						
					$func = '<ul class="function_buttons">';
				    $func .= '<li class="function_edit btn btn-link active" data-id="'     .   $row['id'] .   '"   data-name="' . $row['project_name'] . '">'.$row['project_name'].'</li>';
					$func .= '<li class="function_delete glyphicon glyphicon-trash glyphicon-globe" data-id="'   .   $row['id']   . '"   data-name="' . $row['project_name'] . '"></li>';
					$func .= '</ul>';
					//Turns out the database isn't as normalized as we hoped...c
					$results_data[] = array( 'project_name' => $row['project_name'], 'project_address' => $row['project_address'], 'project_city' => $row['project_city'], 'project_state' => $row['project_state'], 'project_zip' => $row['project_zip'], 'function' => $func);
					//print_r($results_data);
				}       
			}
			
			if (!$query) {
				$result = 'error ' . $db_connection -> error . " " . $query;
				$message = 'query error';
			} else {
				$result = 'success' . $sql;
				$message = 'query success';
			}
						
			return $results_data;
		}

		function deleteExistingProject($projID, $userID,$db_connection,$system,$pjID) {
			$projectname = mysqli_real_escape_string($db_connection, $projID) ;
			$sql = "DELETE FROM `powersite_project_data` WHERE `project_cust_id`=" . mysqli_real_escape_string($db_connection, (int)$userID) 
			." AND `project_name`=" . "'$projectname'" . " AND `id`=" . "'$pjID'" . "LIMIT 1";

			$query = mysqli_query($db_connection, $sql);
			
			if (!$query) {
				$result = 'error ' . $db_connection -> error . " " . $query;
				$message = 'query error';
			} else {
				$result = 'success' ;
				$message = 'query success';
			}
						
			return $result;
			
		}

		function getProjectDetails($db_connection, $userID, $projID, $system, $pjID) {
				$projectname = mysqli_real_escape_string($db_connection, $projID) ;
			$sql = "SELECT * FROM `powersite_project_data` WHERE `project_name`=" . "'$projectname'" . "AND `project_cust_id`=" . mysqli_real_escape_string($db_connection, $userID) 
			. " AND `project_system_id`=". "'$system' " . " AND `id`=" . "'$pjID'". "LIMIT 1";
 			$results_data = array();
			//$query = mysqli_query($db_connection, $sql);
			if ($query = mysqli_query($db_connection, $sql)) {
				while ($row = mysqli_fetch_assoc($query)) {
					$results_data = $row;
					}
				}
			if (!$query) {
				$result = 'error ' . $db_connection -> error . " " . $query;
				$message = 'query error';
			} else {
				$result = 'success' ;
				$message = 'query success';
			}
			return  $results_data;
		}

		function projectCount($_GET,$userID,$db_connection,$system,$isUpdate){
			 							
			$Projectquery ="SELECT COUNT(`project_cust_id`) as count  FROM `powersite_project_data` WHERE ";
			$Projectquery  .= "project_cust_id= '" . mysqli_real_escape_string($db_connection, (int)$userID) . "'";				
			$Projectquery .= "AND project_system_id='" .mysqli_real_escape_string($db_connection, $system)."'";
			$query = mysqli_query($db_connection, $Projectquery);
			$resultarr = mysqli_fetch_assoc($query);
			if (!$query) {
				$result = 'error ' . $db_connection -> error . " " . $query;
				$message = 'query error';
			} else {
				$result = 'success';
				$message = 'query success';
			}
			return 	array("result meesage" => $result, "data" => $resultarr["count"]);
			
		}

		function saveProjectDetails($_GET, $userID, $db_connection, $system,$isUpdate) {
		   
						
			$query = "INSERT INTO  powersite_project_data SET ";
			if (isset($_GET['projectname'])) { $query .= "project_name = '" . mysqli_real_escape_string($db_connection, $_GET['projectname']) . "', ";
			}
			if (isset($_GET['projectaddress'])) { $query .= "project_address= '" . mysqli_real_escape_string($db_connection, $_GET['projectaddress']) . "', ";
			}
			if(isset($_GET['cellType'])){ $query .= "project_cell_type= '" .  $_GET['cellType'] ."', ";
			}
			if (isset($_GET['State'])) { $query .= "project_state  = '" . mysqli_real_escape_string($db_connection, $_GET['State']) . "', ";
			}
			if (isset($_GET['City'])) { $query .= "project_city      = '" . mysqli_real_escape_string($db_connection, $_GET['City']) . "', ";
			}
			if (isset($_GET['projzip'])) { $query .= "project_zip  = '" . mysqli_real_escape_string($db_connection, $_GET['projzip']) . "', ";
			}
			if (isset($_GET['moduleWidth'])) { $query .= "project_width = '" . mysqli_real_escape_string($db_connection, $_GET['moduleWidth']) . "', ";
			}
			if (isset($_GET['moduleThickness'])) { $query .= "project_thickness   = '" . mysqli_real_escape_string($db_connection, $_GET['moduleThickness']) . "', ";
			}
			if (isset($_GET['moduleColumns'])) { $query .= " project_column= '" . mysqli_real_escape_string($db_connection, $_GET['moduleColumns']) . "',";
			}
			if (isset($_GET['tilt'])) { $query .= "project_tilt= '" . mysqli_real_escape_string($db_connection, $_GET['tilt']) . "',";
			}
			if (isset($_GET['design'])) { $query .= "project_foundation= '" . mysqli_real_escape_string($db_connection, $_GET['design']) . "',";
			}
			if (isset($_GET['codeVersion'])) { $query .= "project_building_code= '" . mysqli_real_escape_string($db_connection, $_GET['codeVersion']) . "',";
			}
			if (isset($_GET['seismic'])) { $query .= "project_seis= '" . mysqli_real_escape_string($db_connection, $_GET['seismic']) . "',";
			}
			if (isset($_GET['wind'])) { $query .= "project_wind_load= '" . mysqli_real_escape_string($db_connection, $_GET['wind']) . "',";
			}
			if (isset($_GET['snow'])) { $query .= "project_snow_load= '" . mysqli_real_escape_string($db_connection, $_GET['snow']) . "',";
			}
			if (isset($_GET['numberRacks'])) { $query .= "project_num_racks= '" . mysqli_real_escape_string($db_connection, $_GET['numberRacks']) . "',";
			}
			
			$query .= "project_system_id= '" . mysqli_real_escape_string($db_connection, $system) . "',";
			$query .= "project_cust_id= '" . mysqli_real_escape_string($db_connection, (int)$userID) . "'";				

			$query = mysqli_query($db_connection, $query);
			//}
			if (!$query) {
				$result = 'error ' . $db_connection -> error . " " . $query;
				$message = 'query error';
			} else {
				$result = 'success';
				$message = 'query success';
			}
			return $result;
			//} //endelse
			
		}
				
						
		function updateproject($_GET ,$db_connection , $isUpdate , $userID ,$system){
			
			if(isset($isUpdate)){
				
				$query = "UPDATE `powersite_project_data` SET ";
				$query .= "`project_name`= '".$_GET['projectname']."' ,`project_address`='".$_GET['projectaddress']."',`project_city`='".$_GET['City']."',"; 
				$query .= "`project_state`='".$_GET['State']."',`project_zip`='".$_GET['projzip']."',`project_cell_type`='".$_GET['cellType']."',`project_tilt`='".$_GET['tilt']."',";
				$query .= "`project_thickness`='".$_GET['moduleThickness']."',`project_width`='".$_GET['moduleWidth']."',";
				$query .= "`project_column`='".$_GET['moduleColumns']."',`project_building_code`='".$_GET['codeVersion']."',`project_seis`='".$_GET['seismic']."',";
				$query .= "`project_wind_load`='".$_GET['wind']."',`project_snow_load`='".$_GET['snow']."',`project_num_racks`='".$_GET['numberRacks']."',`project_system_id`='".$system."',";
				$query .= "`project_cust_id`= '".$userID."'   WHERE  `id`='".$isUpdate."' LIMIT 1";
				}
			
				$query = mysqli_query($db_connection, $query);

				if (!$query) {
				$result = 'error ' . $db_connection -> error . " " . $query;
				$message = 'query error';
				} else {
				$result = 'success update';
				$message = 'query success update';
				}
				
			return $result;
				
			}

	$results_data = array();
	if ($job == 'get_projects') {
			$results_data = getExistingProjects($db_connection, $userID,$system);
		} elseif ($job == 'get_project') {
			$results_data = getProjectDetails($db_connection, $userID, $projID,$system, $pjID);			
		} elseif ($job == 'add_project') {
			$results_data = saveProjectDetails($_GET, $userID, $db_connection, $system, $isUpdate);
		}elseif($job == 'check_project'){
			 $results_data = projectCount($_GET, $userID, $db_connection, $system, $isUpdate);
		} elseif ($job == 'update_project') {
			$results_data = 	updateproject($_GET, $db_connection, $isUpdate, $userID,$system);
		} elseif ($job == 'delete_project') {			
			$results_data = deleteExistingProject($projID, $userID,$db_connection,$system,$pjID);
		}
	}   

	// Prepare data
	$data = array(
	//"result"  => $result,
	//"message" => $message,	
	"data" => $results_data,
	"message" => "success");

	// Convert PHP array to JSON array
	$json_data = json_encode($data);
	echo $json_data;
?>