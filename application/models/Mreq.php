<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mreq extends CI_Model {

	// coonnect to DB
	function connect(){
		$conn=$this->load->database("", true);
		return $conn;
	}

	// get email from DB
	function email($inputEmail){
		$conn=$this->connect();
		$values=$conn->query("SELECT `Email` FROM `registration` WHERE `Email` ='$inputEmail'");
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
	function upload($formname, $date, $time, $pipename, $uploadedby, $uniqueid, $creator, $wtd, $track){
		$conn=$this->connect();
		$values=$conn->query("INSERT INTO `req`.`upload` (`Id`, `FormName`, `Date`, `Time`, `PipeName`, `UploadedBy`, `UniqueId`, `Creator`, `Wtd`, `Track`) VALUES (NULL, '$formname', '$date', '$time', '$pipename', '$uploadedby', '$uniqueid', '$creator', '$wtd', '$track')");
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
	function intosend($formname, $date, $time, $pipename, $uniqueid, $sentto, $sentby, $creator, $status, $track){
		$conn=$this->connect();
		$values=$conn->query("INSERT INTO `req`.`sent`(`Id`, `FormName`, `Date`, `Time`, `PipeName`, `UniqueId`, `SentTo`, `SentBy`, `Creator`, `Status`, `Track`) VALUES (NULL, '$formname', '$date', '$time', '$pipename', '$uniqueid', '$sentto', '$sentby', '$creator', '$status', '$track')");
		return $values;
	}

	// insert into received table on DB
	function intoreceived($formname, $date, $time, $pipename, $uniqueid, $receivedby, $sentby, $creator, $status, $wtd, $track){
		$conn=$this->connect();
		$values=$conn->query("INSERT INTO `req`.`received`(`Id`, `FormName`, `Date`, `Time`, `PipeName`, `UniqueId`, `ReceivedBy`, `SentBy`, `Creator`, `Status`, `Wtd`, `Track`) VALUES (NULL, '$formname', '$date', '$time', '$pipename', '$uniqueid', '$receivedby', '$sentby', '$creator', '$status', '$wtd', '$track')");
		return $values;
	}

	// delete from uploads table on DB
	function deletefupload($uniqueid, $uploadedby){
		$conn=$this->connect();
		$values=$conn->query("DELETE FROM `upload` WHERE `UniqueId` = '$uniqueid' AND `UploadedBy` = '$uploadedby'");
		return $values;
	}

	// insert into pipe__ ?? table in DB
	function intounpipe($pipename, $creator, $Fromwho, $towho, $uniqueid, $status, $track){
		$conn=$this->connect();
		$values=$conn->query("INSERT INTO `req`.`$pipename`(`Id`, `Creator`, `FromWho`, `ToWho`, `UniqueId`, `Status`, `Track`) VALUES (NULL, '$creator', '$Fromwho', '$towho', '$uniqueid', '$status', '$track')");
		return $values;
	}

	// get all user on DB info
	function getuserinfo($email){
		$conn=$this->connect();
		$values=$conn->query("SELECT `FirstName`, `LastName`, `Department`, `Email`, `ProfilePic`, `OnlineP` FROM `registration` WHERE `Email` <> '$email'");
		return $values;
		
	}

	// get form details from uploads table with unique id
	function getformdetails($uniqueid, $uploadedby){
		$conn=$this->connect();
		$values=$conn->query("SELECT `PipeName`, `Creator`, `FormName`, `Wtd`, `Track` FROM `Upload` WHERE `UniqueId` = '$uniqueid' AND `UploadedBy` = '$uploadedby'");
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

	// get info of received data from received table using received by 
	function getreceived($receivedby){
		$conn=$this->connect();
		$values=$conn->query("SELECT * FROM `req`.`received` WHERE `ReceivedBy` = '$receivedby'");
		return $values;
	}

	// update status of form for sent table
	function updatestat($status, $uniqueid, $sentto){
		$conn=$this->connect();
		$values=$conn->query("UPDATE `sent` SET `Status` = '$status' WHERE `UniqueId` = '$uniqueid' AND `SentTo` = '$sentto'");
		return $values;
	}

	// update status of form for received table
	function updatestat_r($status, $uniqueid, $receivedby){
		$conn=$this->connect();
		$values=$conn->query("UPDATE `received` SET `Status` = '$status' WHERE `UniqueId` = '$uniqueid' AND `ReceivedBy` = '$receivedby'");
		return $values;
	}

	// update status on pipe table
	function updatepipestat($pipename, $status, $uniqueid, $towho){
		$conn=$this->connect();
		$values=$conn->query("UPDATE `$pipename` SET `Status` = '$status' WHERE `UniqueId` = '$uniqueid' AND `ToWho` = '$towho'");
		return $values;
	}

	// get pipename from received table for particular unique id
	function receievedpipe($uniqueid, $receivedby){
		$conn=$this->connect();
		$values=$conn->query("SELECT `PipeName` FROM `req`.`received` WHERE `UniqueId` = '$uniqueid' AND `ReceivedBy` = '$receivedby'");
		return $values;
	}

	// insert into approved table
	function approvedtable($formname, $date, $time, $pipename, $uniqueid, $receivedby, $sentby, $creator, $status, $track){
		$conn=$this->connect();
		$values=$conn->query("INSERT INTO `req`.`approved` (`Id`, `FormName`, `Date`, `Time`, `PipeName`, `UniqueId`, `ApprovedBy`, `SentBy`, `Creator`, `Status`, `Track`) VALUES (NULL, '$formname', '$date', '$time', '$pipename', '$uniqueid', '$receivedby', '$sentby', '$creator', '$status', '$track')");
		return $values;
	}

	//get info of received data from received table using unique id
	function getreceiveduid($uniqueid){
		$conn=$this->connect();
		$values=$conn->query("SELECT `FormName`, `Creator`, `SentBy` ,`Track` FROM `req`.`received` WHERE `UniqueId` = '$uniqueid'");
		return $values;
	}

	//get approved status from aprroved table
	// function getapprovedstat($uniqueid, $receivedby){
	// 	$conn=$this->connect();
	// 	$values=$conn->query("SELECT `Status` FROM `req`.`approved` WHERE `UniqueId` = '$uniqueid' AND `ApprovedBy` = '$receivedby'");
	// 	return $values;
	// }

	// get approved data from DB 
	function approved($receivedby){
		$conn=$this->connect();
		$values=$conn->query("SELECT * FROM `req`.`approved` WHERE `ApprovedBy` = '$receivedby'");
		return $values;
	}

	//get profile details from DB
	function profile($email){
		$conn=$this->connect();
		$values=$conn->query("SELECT `FirstName`,`LastName`,`Department`,`Team`,`IdNum`,`ProfilePic`,`OnlineP` FROM `req`.`registration` WHERE `Email` = '$email'");
		return $values;
	}

	// send details to declined table
	function ideclined($formname, $date, $time, $pipename, $declinedby, $declinedto, $uniqueid, $reason, $creator, $status, $track){
		$conn=$this->connect();
		$values=$conn->query("INSERT INTO `req`.`declined` (`Id`, `FormName`, `Date`, `Time`, `PipeName`, `DeclinedBy`, `DeclinedTo`, `UniqueId`, `Reason`, `Creator`, `Status`, `Track`) VALUES (NULL, '$formname', '$date', '$time', '$pipename', '$declinedby', '$declinedto', '$uniqueid', '$reason', '$creator', '$status', '$track')");
		return $values;
	}

	//get all from declined table
	function getdeclined($declinedby){
		$conn=$this->connect();
		$values=$conn->query("SELECT * FROM `req`.`declined` WHERE `DeclinedBy` = '$declinedby'");
		return $values;
	}

	// get from received where uniqueID is given
	function ureceived($uniqueid){
		$conn=$this->connect();
		$values=$conn->query("SELECT * FROM `req`.`received` WHERE `UniqueId` = '$uniqueid'");
		return $values;
	}

	// get the creator information from the pipe table
	function getunpipe($pipename, $towho){
		$conn=$this->connect();
		$values=$conn->query("SELECT `Creator`, `Track` FROM `req`.`$pipename` WHERE `ToWho` = '$towho'");
		return $values;
	}

	// delete from specific pipe table 
	function delunpipe($pipename,$track){
		$conn=$this->connect();
		$values=$conn->query("DELETE FROM `req`.`$pipename` WHERE `Track` = '$track'");
		return $values;
	}

	// update status of form for sent table for done
	function nupdatestat($status, $track){
		$conn=$this->connect();
		$values=$conn->query("UPDATE `sent` SET `Status` = '$status' WHERE `Track` = '$track'");
		return $values;
	}

	// update status of form for received table for done
	function nupdatestat_r($status, $track){
		$conn=$this->connect();
		$values=$conn->query("UPDATE `received` SET `Status` = '$status' WHERE `Track` = '$track'");
		return $values;
	}

	// update status of form for received table for done
	function nupdatestat_rr($status, $wtd, $track){
		$conn=$this->connect();
		$values=$conn->query("UPDATE `received` SET `Status` = '$status', `Wtd` = '$wtd' WHERE `Track` = '$track'");
		return $values;
	}

	// select all form specific pipe table
	function allspipe($pipename){
		$conn=$this->connect();
		$values=$conn->query("SELECT * FROM `req`.`$pipename`");
		return $values;
	}

	// to check if the pipe belong to you for sending
	function ifitsforu($pipename){
		$conn=$this->connect();
		$values=$conn->query("SELECT `ToWho` FROM `$pipename` ORDER BY `Id` DESC");
		return $values;
	}

	// insert into final table
	function final($formname, $date, $time, $pipename, $uniqueid, $receivedby, $sentby, $creator, $status, $track){
		$conn=$this->connect();
		$values=$conn->query("INSERT INTO `req`.`final` (`Id`, `FormName`, `Date`, `Time`, `PipeName`, `UniqueId`, `ApprovedBy`, `SentBy`, `Creator`, `Status`, `Track`) VALUES (NULL, '$formname', '$date', '$time', '$pipename', '$uniqueid', '$receivedby', '$sentby', '$creator', '$status', '$track')");
		return $values;
	}
}
?>