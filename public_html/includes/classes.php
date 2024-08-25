<?php
session_start();
include('connection.php');

//Data base connectivity class
class db_connect
{

	function connection($sql_host,$sql_user,$sql_password,$sql_db)
	{
	
		$con=mysqli_connect($sql_host,$sql_user,$sql_password);
		if(!$con)
		{
			die("Could not connect to database");
		}
		mysqli_select_db($sql_db,$con);
		}
		
		function disconnect()
		{
			mysqli_close($con);
		}
	}
/////////////////////////////////////////////////////////////////
class mailing
{
var $from;
var $state;
var $cmt;
function sendmail($to,$subject,$message)
{

$sql="SELECT * FROM `cms_admin` WHERE `username`='admin'";

$result=mysqli_query($sql);

$rs=mysqli_fetch_array($result);

$f=$rs['email'];

$header  = 'MIME-Version: 1.0' . "\r\n";
$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

//$header.="From:".$this->from=$from;
//$f="bee-india.nic.in";
$header.="From:".$f;
mail($to,$subject,$message,$header);

}

}



//////Authentication class Start///////////////
class authentication extends mailing
{
var $msg;
var $status;
	function login($username,$password)
	{
		$msg ="Login Failed!". "<br/>";
		$msg .= "Wrong Username or Password";
		$sql = "SELECT * FROM admin WHERE username ='$username' AND password='$password'";
		$result = mysqli_query($sql);
		$num = mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
//print_r($row);
//die;
		if($num > 0)
		{
			$_SESSION['user'] = $username;
			$_SESSION['fname'] = $row['firstname']; 
			$_SESSION['lname'] = $row['lastname']; 
			$_SESSION['userid'] = $row['id']; 
			header("location:index.php");

			
			/*if(empty($_SESSION['url']))
			{
				header("location:index.php");
			}
			else
			{
				$url=$_SESSION['url'];
				header("location:$url");
			}*/
		}
		else
		{
			$this->msg=$msg;
		}
	}

}
////////////Authontication class end/////////////////

//////Authentication class login Start///////////////
class authenticat extends mailing
{
var $msg;
var $status;
function login($username,$password)
{
	echo "fsdf";
	die;
$msg="Login Failed";
echo $sql="SELECT * FROM users  WHERE username='$username' AND password='$password'";
$result=mysqli_query($sql);
$num=mysqli_num_rows($result);
if($num>0)
{
	$_SESSION['user'] = $username;
	if(empty($_SESSION['ur']))
	{
	header("location:home.php");
	}
	else
	{
	$url=$_SESSION['ur'];
	header("location:$url");
	}
	//}
	}
	else
	{
	$this->msg=$msg;
	}
	}

}
////////////Authontication class login end/////////////////

//Product management classes.

class contenttype
{
var $msg;
var $notice;
var $error;
var $del;
function addtype()
{
@extract($_POST);

$num=strlen(trim($typename));

if($num<=0)
{
$this->error="Please enter Content type";
}
else
{
$type=trim($typename);

$sql="INSERT INTO `titlecontent` VALUES ('','$type')";

$result=mysqli_query($sql);
if(!$result)
{
$this->msg="Value not inserted";
$this->notice="fail";
}
else
{
$this->msg="Value inserted successfully";
$this->notice="sus";
}
}
}

function delete($ID)
{
$sq="DELETE FROM `titlecontent` WHERE id='$ID'";
$rs=mysqli_query($sq);





if(!rs)
{
$this->del="false";
$this->error="Some Error In Deletion";

}
else
{
$this->del="true";
$this->msg="Value deleted successfully";
}
}




}


?>
