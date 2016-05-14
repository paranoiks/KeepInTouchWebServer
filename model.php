<?php

require_once('dbCredentials.php');
require_once('logger.php');

function Connect()
{
	global $dbHost, $dbUser, $dbPass, $dbName;
	
	$link = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);	

	return $link;
}

function ModelGetUserInfo($username)
{
	$link = Connect();	

	$query = "SELECT * FROM Users WHERE username = '" . $username ."'";

	$result = mysqli_query($link, $query);	

	mysqli_close($link);	

	if($result == null)
	{
		return null;
	}	

	$userInfo = mysqli_fetch_assoc($result);

	return $userInfo;
}

function ModelAddContact($userId, $params)
{
	$link = Connect();	

	$tableName = "Contacts_" . $userId;	

	$query = "INSERT INTO " . $tableName;	

	$paramsCount = count($params);

	$i = 0;	

	foreach($params as $paramKey => $paramValue)
	{
		$query .= "SET " . $paramKey . " = " . $paramValue;
		if($i < $paramsCount - 1)
		{
			$query .= ",";
		}
		$i++;
	}

	mysqli_query($link, $query);
	mysqli_close($link);
}

function ModelEditContact($userId, $contactId, $params)
{
	$link = Connect();

	$tableName = "Contacts_" . $userId;	

	$paramsCount = count($params);

	$i = 0;

	$query = "UPDATE" . $tableName;

	foreach($row as $paramKey => $paramValue)
	{
		if($paramValue != null)
		{
			$query .= "SET " . $paramKey . " = " . $paramValue;
			if($i < $paramsCount - 1)
			{
				$query .= ",";
			}
		}	

		$i++;
	}

	$query .= " WHERE id = " . $contactId;

	mysqli_close($link);
}

function ModelGetAllContacts($userId)
{
	$link = Connect();

	$tableName = "Contacts_" . $userId;

	$query = "SELECT * FROM " . $tableName . " ORDER BY last_communication_date ASC";	

	$result = mysqli_query($link, $query);	

	mysqli_close($link);	

	$contacts = array();
	$i = 0;

	while($row = mysqli_fetch_assoc($result))
	{
		$contacts[$i] = $row;
		$i++;
	}	

	return $contacts;
}

function ModelAddContactNote($userId, $contactId, $note)
{
	$link = Connect();

	$tableName = "Notes_" . $userId;

	$query = "INSERT INTO " . $tableName . " SET " .
		"contact_id='" . $contactId . "', " .
		"note='" . $note . "'";

	mysqli_query($link, $query);

	mysqli_close($link);
}

function ModelGetAllNotesForContact($userId, $contactId)
{
	$link = Connect();

	$tableName = "Notes_" . $userId;

	$query = "SELECT * FROM " . $tableName . " WHERE contact_id='" . $contactId . "'";

	$result = mysqli_query($link, $query);

	mysqli_close($link);

	$notes = array();
	$i = 0;

	while($row = mysqli_fetch_assoc($result))
	{
		$notes[$i] = $row;
		$i++;
	}

	return $notes;
}

?>