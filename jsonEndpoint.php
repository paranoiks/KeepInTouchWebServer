<?php

require_once('model.php');
require_once('logger.php');

$action = get_param('action');

switch($action)
{
	case 'addContact':
		break;
	case 'editContact':
		break;
	case 'getAllContacts':
		GetAllContacts();
		break;
	case "addContactNote":
		AddContactNote();
		break;
	case "getAllNotesForContact":
		GetAllNotesForContact();
		break;
}

//Check if the supplied username and password correspond to an actual user in the database
function CheckUser()
{
	$username = get_param('username');
	$userPassword = get_param('password');	


	$userInfo = ModelGetUserInfo($username);

	if($userInfo == null)
	{
		return null;
	}	

	if($userInfo['password'] != $userPassword)
	{
		return null;
	}

	return $userInfo;
}

//add a new contact for the given user
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

//edit the info for a contact for the given user
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

//get all contacts for the given user
function GetAllContacts()
{
	$userInfo = CheckUser();

	if($userInfo == null)
	{
		return;
	}	

	echo json_encode(ModelGetAllContacts($userInfo['id']));
}

//add a note for a certain contact
function AddContactNote()
{
	$userInfo = CheckUser();

	if($userInfo == null)
	{
		return;
	}

	$contactId = get_param('contact_id');
	$note = get_param('note');

	ModelAddContactNote($userInfo['id'], $contactId, $note);
}

//get all notes for a certain contact
function GetAllNotesForContact()
{
	$userInfo = CheckUser();	

	if($userInfo == null)
	{
		return;
	}

	$contactId = get_param('contact_id');

	$notes = ModelGetAllNotesForContact($userInfo['id'], $contactId);

	echo json_encode($notes);
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