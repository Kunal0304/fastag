<?php 

include("connection.php");

/*function isuser($username, $password)

{



	echo $sql = "SELECT * FROM users WHERE user_name = '$username' AND password = '$password'";

	$result = mysqli_query($sql);

	$row = mysqli_fetch_array($result);

	if(mysqli_num_rows($result) > 0 )

	{

		$_SESSION['user'] = $row['user_name'];

		$_SESSION['fname'] = $row['first_name'];

		$_SESSION['lname'] = $row['last_name'];

		//header("Location:index.php");

	}

	else

	{

		$msg = "Wrong username or password!";

	}

}*/



function getValueById($Name, $Table, $Condition = "", $OrdBy = "")

	{

		if(!empty($Condition))

		{

			   $query = "SELECT $Name FROM $Table

				WHERE  $Condition $OrdBy";

		}

		else

		{

			 $query = "SELECT $Name FROM $Table

				 $OrdBy";

		}

			

		$getRecordsRes = mysqli_query($query);

		

		if (mysqli_num_rows($getRecordsRes) > 0)

			$ReturnName = mysqli_result($getRecordsRes, 0, $Name);

		else

			$ReturnName = "";

	

		return $ReturnName;

	}

	



function check_value($Fields, $Table, $Condition = "", $OrdBy = "")

{

	if(!empty($Condition))

	{

		$query = "SELECT $Fields FROM $Table

				WHERE  $Condition $OrdBy";

	}

	else

	{

		$query = "SELECT $Fields FROM $Table

				 $OrdBy";

	}

//echo 	$query;

//die;

	$getRecordsRes = mysqli_query($query) ;

		

	if (mysqli_num_rows($getRecordsRes) > 0)

	{

		$ReturnRecord = mysqli_fetch_array($getRecordsRes);

	}

	else

	{

		$ReturnRecord = "";

	}

	return $ReturnRecord;

}

function insert($tablename, $fields, $values)

{

extract($_POST);

 $sql = "INSERT INTO $tablename($fields) 

  			VALUES ($values)";

			

//echo $sql;

//die;			

 $result = mysqli_query($sql) ;

 $insertd_id = mysqli_insert_id();

  if($result)

  {

    $msg  = "Added Successfully.";

  }	

  else

  {

     if (mysqli_errno()=='1064') 

		     die("We already have entry of your Entries");

    $msg  = "Could not be added.";

  }	

  	if($insertd_id != "")

  		return $insertd_id;

		

  return $msg; 	

}

	



function update($tablename , $fields, $Condition= "")

{

	if(!empty($Condition))

	{

 		$sql = "UPDATE $tablename SET $fields WHERE $Condition";

	}

	else

	{

 		$sql = "UPDATE $tablename SET $fields ";

	}	

//echo $sql;



//die;	

	$result = mysqli_query($sql);

//die;

	//if(mysqli_affected_rows() > 0 )

	if($result)

	{

		$msg  = "Updated Successfully.";

  	}	

    else

    {

		$msg  = "Could not be updated.";

  	}

	return 	$msg;	

}





function UploadFile($FilesArray, $Folder, $Field = "")

{

	$FileName = "";



	if(!empty($FilesArray['tmp_name']))

	{

		if (!file_exists($Folder))

			mkdir($Folder);

		

		  $UploadFileName = $FilesArray['name'];	



		  $random_digit = rand(0000,9999);

		  $NewUploadFileName = $random_digit.'_'.$UploadFileName;

		

		if (move_uploaded_file($FilesArray['tmp_name'], $Folder.'/'.$NewUploadFileName) == false)

			return false;

		$FileName = $NewUploadFileName;

	}



	return $FileName;

}





function deleteMultipleRecords($idsArray, $Table, $Condition = "")

{

	for($i = 0 ; $i < count($idsArray); $i++)

	{

$project_id = $idsArray[$i];	

		if(!empty($Condition))

		{

			$query = "DELETE FROM $Table

					WHERE  $Condition";

		}

		else

		{

			$query = "DELETE FROM $Table WHERE id = $project_id";

		}

		$result = mysqli_query($query) || die(mysqli_error());

	}

	if($result)

	{

		$msg  = "Deleted Successfully.";

  	}	

    else

    {

		$msg  = "Could not be deleted.";

  	}

	return 	$msg;	

	

}



function getCount($tablename, $fieldName, $Condition= "")

{

	if(!empty($Condition))

	{

 		$sql = "SELECT count($fieldName) AS TOTALCOUNT FROM $tablename WHERE $Condition";

	}

	else

	{

 		$sql = "SELECT count($fieldName) AS TOTALCOUNT FROM $tablename";

	}	

	$result = mysqli_query($sql);



	$row = mysqli_fetch_array($result);



	if(!empty($row))

		$totalcount = $row['TOTALCOUNT'];

	else	

		$totalcount = 0;	

	

	return 	$totalcount;	

	

}



function dateadd($day,$toadd) //input format: d/m/yyyy

{

//echo $day . "<br/>";

$tmp = explode("-",$day);



$dadate = mktime(0,0,0,$tmp[1],$tmp[0]+($toadd),$tmp[2]);

//echo date("d/m/Y",$dadate);

//die;	

return date("d-m-Y",$dadate);

}





function generateDropDown($tablename, $condition)

{

 	$sql = "SELECT * FROM $tablename WHERE $condition";		

	$result = mysqli_query($sql);



	while($row = mysqli_fetch_array($result))

	{

	 	$options[] = $row; 

	}

return 	$options;

}



function getlist($Table, $Condition = "")

{

	if($Condition == "")

	{

		$sql = "SELECT * FROM $Table";

	}

	else

	{

		$sql = "SELECT * FROM $Table WHERE $Condition";

	}

//echo $sql;		

	$result = mysqli_query($sql);

	while($row = mysqli_fetch_array($result))

	{

		$records[] = $row;

	}

	return $records;

}





function deleteRecord($Table, $Condition = "")

{

	if($Condition == "")

	{

		$sql = "DELETE FROM $Table";

	}

	else

	{

		$sql = "DELETE FROM $Table WHERE $Condition";

	}

	$result = mysqli_query($sql);

}



function deactivateRecord($Table, $Condition = "")

{

	if($Condition == "")

	{

		$sql = "UPDATE $Table SET active = 'N'";

	}

	else

	{

		$sql = "UPDATE $Table SET active = 'N' WHERE $Condition";

	}

//echo $sql;	

	$result = mysqli_query($sql) || die(mysqli_error());

}



function activateRecord($Table, $Condition = "")

{

	if($Condition == "")

	{

		$sql = "UPDATE $Table SET active = 'Y'";

	}

	else

	{

		$sql = "UPDATE $Table SET active = 'Y' WHERE $Condition";

	}

	$result = mysqli_query($sql);

}



function getRecord($Table, $Condition = "")

{

	if($Condition == "")

	{

		$sql = "SELECT * FROM $Table";

	}

	else

	{

		$sql = "SELECT * FROM $Table WHERE $Condition";

	}

	$result = mysqli_query($sql);

	$row = mysqli_fetch_array($result); 

	return $row;

}



?>