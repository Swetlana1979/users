<?php

function startup()
{
	// Настройки подключения к БД.
	$hostname = 'localhost'; 
	$username = 'root'; 
	$password = '';
	$dbName = 'users';
	
	// Языковая настройка.
	setlocale(LC_ALL, 'ru_RU.UTF8');	//
	
	// Подключение к БД.
	mysql_connect($hostname, $username, $password) or die('No connect with data base'); 
	mysql_query('SET NAMES utf8'); //
	mysql_select_db($dbName) or die('No data base');

	// Открытие сессии.
	session_start();
	
	/*mb_internal_encoding("UTF-8");*/
		
}
