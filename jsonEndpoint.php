<?php

$action = get_param('action');

switch($action)
{
	case 'addContact':
		break;
	case 'editContact':
		break;
	case 'getAllContacts':
		break;
}

function CheckUser()
{
	$username = get_param('username');
	$userPassword = get_param('userPassword');
	
	$userInfo = GetUserInfo($username);
	
	if($userInfo == null)
	{
		return;
	}
	
	if($userInfo['password'] != $userPassword)
	{
		return;
	}
	
	return $userInfo;
}

function AddContact()
{
	$userInfo = CheckUser();
	if($userInfo == null)
	{
		return;
	}
	
	$params = json_decode(get_param('params'));
	
	ModelAddContact($userInfo['id'], $params);
}

function EditContact()
{
	$userInfo = CheckUser();
	if($userInfo == null)
	{
		return;
	}
	
	$params = json_decode(get_param('params'));
	
	ModelEditContact($userInfo['id'], $params);
}

function GetAllContacts()
{
	$userInfo = CheckUser();
	if($userInfo == null)
	{
		return;
	}
	
	return json_encode(ModelGetAllContacts($userInfo['id']));
}

function get_param($param)
{
	if($_GET[$param] != null)
	{
		return $_GET[$param];
	}
	
	return $_POST[$param];
}

?>