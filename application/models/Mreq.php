<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mreq extends CI_Model {

	// coonnect to DB
	function connect(){
		$conn=$this->load->database("", true);
		return $conn;
	}

	// get email from DB
	function email(){
		$conn=$this->connect();
		$values=$conn->query("SELECT `Email` FROM `registration`");
		return $values;
	}

	// get password for particular email from DB
	function getPassword($inputEmail){
		$conn=$this->connect();
		$values=$conn->query("SELECT `Password` FROM `registration` WHERE Email = '$inputEmail'");
		return $values;
	}

	// get activation status for particular email from DB
	function activationStat($inputEmail){
		$conn=$this->connect();
		$values=$conn->query("SELECT `Activated` FROM `registration` WHERE Email = '$inputEmail'");
		return $values;
	}

	// get pipes that are in use from DB
	function pipeinuse(){
		$conn=$this->connect();
		$values=$conn->query("SELECT `PipeName` FROM `pipelist` WHERE Status = 'inuse'");
		return $values;
	}

	// get pipes that are not in use from DB
	function pipenotinuse(){
		$conn=$this->connect();
		$values=$conn->query("SELECT `PipeName` FROM `pipelist` WHERE Status = 'notinuse'");
		return $values;
	}

	// send to just uploaded DB
	function upload($formname, $date, $time, $pipename, $uploadedby, $uniqueid, $creator){
		$conn=$this->connect();
		$values=$conn->query("INSERT INTO `req`.`upload` (`Id`, `FormName`, `Date`, `Time`, `PipeName`, `UploadedBy`, `UniqueId`, `Creator`) VALUES (NULL, '$formname', '$date', '$time', '$pipename', '$uploadedby', '$uniqueid', '$creator')");
		return $values;
	}

	// collect data from upload table in DB
	function getupload($uploadedby){
		$conn=$this->connect();
		$values=$conn->query("SELECT * FROM `upload` WHERE UploadedBy = '$uploadedby'");
		return $values;
	}

	// update pipelist status on DB to in use
	function upipeinuse($pipename){
		$conn=$this->connect();
		$values=$conn->query("UPDATE `pipelist` SET `Status`= 'inuse' WHERE `PipeName` = '$pipename'");
		return $values;
	}

	// update pipelist status on DB to not in use
	function upipenotinuse($pipename){
		$conn=$this->connect();
		$values=$conn->query("UPDATE `pipelist` SET `Status`= 'notinuse' WHERE `PipeName` = '$pipename'");
		return $values;
	}

	// insert into sent table on DB
	function intosend($formname, $date, $time, $pipename, $uniqueid, $sentto, $sentby, $creator, $status){
		$conn=$this->connect();
		$values=$conn->query("INSERT INTO `req`.`sent`(`Id`, `FormName`, `Date`, `Time`, `PipeName`, `UniqueId`, `SentTo`, `SentBy`, `Creator`, `Status`) VALUES (NULL, '$formname', '$date', '$time', '$pipename', '$uniqueid', '$sentto', '$sentby', '$creator', '$status')");
		return $values;
	}

	// delete from uploads table on DB
	function deletefupload($uniqueid, $uploadedby){
		$conn=$this->connect();
		$values=$conn->query("DELETE FROM `upload` WHERE `UniqueId` = '$uniqueid' AND `UploadedBy` = '$uploadedby'");
		return $values;
	}

	// insert into pipe__ ?? table in DB
	function intounpipe($pipename, $creator, $Fromwho, $towho, $uniqueid, $status){
		$conn=$this->connect();
		$values=$conn->query("INSERT INTO `req`.`$pipename`(`Id`, `Creator`, `FromWho`, `ToWho`, `UniqueId`, `Status`) VALUES (NULL, '$creator', '$Fromwho', '$towho', '$uniqueid', '$status')");
		return $values;
	}

	// get all user on DB info
	function getuserinfo(){
		$conn=$this->connect();
		$values=$conn->query("SELECT `FirstName`, `LastName`, `Department`, `Email`, `ProfilePic`, `OnlineP` FROM `registration`");
		return $values;
		
	}

	// get form details from uploads table with unique id
	function getformdetails($uniqueid, $uploadedby){
		$conn=$this->connect();
		$values=$conn->query("SELECT `PipeName`, `Creator`, `FormName` FROM `Upload` WHERE `UniqueId` = '$uniqueid' AND `UploadedBy` = '$uploadedby'");
		return $values;
	}

	// get all from sent table belonging to this user
	function senttable($sentby){
		$conn=$this->connect();
		$values=$conn->query("SELECT * FROM `Sent` WHERE `SentBy` = '$sentby'");
		return $values;
	}

	// get only pipe name from uploads table with unique id
	function getpipeformname($uniqueid, $uploadedby){
		$conn=$this->connect();
		$values=$conn->query("SELECT `PipeName`, `FormName` FROM `Upload` WHERE `UniqueId` = '$uniqueid' AND `UploadedBy` = '$uploadedby'");
		return $values;
	}
}
?>