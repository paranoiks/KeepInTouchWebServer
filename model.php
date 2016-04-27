<?php

require_once('dbCredentials.php');

function Connect()
{
	$link = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
	
	return $link;
}

function ModelGetUserInfo($username)
{
	$link = Connect();
	
	$query = "SELECT FROM Users WHERE username = " . $username;
	$result = mysqli_query($link, $query);
	
	mysqli_close($link);
	
	if($result == null)
	{
		return null;
	}	
	
	return mysqli_fetch_assoc($result);
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
	
	$tableName = "Contacts_" . $userId);
	
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
	
	return $result;
}

?>