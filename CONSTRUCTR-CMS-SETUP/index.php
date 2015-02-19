<?php

	/**
	 * Constructr CMS - a Slim-PHP-Framework based full-stack Content-Management-System (CMS).
	 * 
	 * Built with:
	 * Slim-PHP-Framework (http://www.slimframework.com/)
	 * Bootstrap Frontend Framework (http://getbootstrap.com/)
	 * PHP PDO (http://php.net/manual/de/book.pdo.php)
	 * jQuery (http://jquery.com/)
	 * ckEditor (http://ckeditor.com/)
	 * Codemirror (http://codemirror.net/)
	 * ...
	 * 
	 * LICENCE 
	 * 
	 * DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
	 * Version 1, February 2015
	 * Copyright (C) 2015 Christian Becher | phaziz.com <christian@phaziz.com>
	 * Everyone is permitted to copy and distribute verbatim or modified
	 * copies of this license document, and changing it is allowed as long
	 * as the name is changed.
	 *
	 * DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
	 * TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
	 * 0. YOU JUST DO WHAT THE FUCK YOU WANT TO!
	 *
	 * Visit http://constructr-cms.org
	 * Visit http://blog.phaziz.com/category/constructr-cms/
	 * Visit http://phaziz.com 
	 *
	 * @author Christian Becher | phaziz.com <phaziz@gmail.com>
	 * @copyright 2015 Christian Becher | phaziz.com
	 * @license DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
	 * @link http://constructr-cms.org/
	 * @link http://blog.phaziz.com/category/constructr-cms/
	 * @link http://phaziz.com/
	 * @package ConstructrCMS
	 * @version 1.04.4 / 17.02.2015  
	 *
	 */

    if (version_compare(phpversion(),'5.3.0','<='))
    {
        die('PHP ist kleiner als Version 5.3.0');
    }

    if(!defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH)
    {
        die('Fehler CRYPT_BLOWFISH ist nicht verf&uuml;gbar!');
    }

	function getCurrentUrl()
	{
		$ACT_URL = ((empty($_SERVER['HTTPS'])) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$ACT_URL = str_replace('/CONSTRUCTR-CMS-SETUP/index.php','',$ACT_URL);
		return $ACT_URL;
	}

	require_once('../Config/constructr_user_rights.conf.php');

	session_start();
	error_reporting(-1);
	function create_guid() {static $guid = '';$uid = uniqid("", true);$data = $_SERVER['REQUEST_TIME'];$data .= $_SERVER['HTTP_USER_AGENT'];$data .= $_SERVER['PHP_SELF'];$data .= $_SERVER['SCRIPT_NAME'];$data .= $_SERVER['REMOTE_ADDR'];$data .= $_SERVER['REMOTE_PORT'];$hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));$guid = substr($hash,0,2) . substr($hash,2,2) . substr($hash,4,2) . substr($hash,8,2);return $guid;}
	$NEW_GUID1 = create_guid();
	$NEW_GUID2 = create_guid();
	$NEW_GUID3 = create_guid();
	$NEW_GUID4 = create_guid();
	$NEW_GUID5 = create_guid();
	$NEW_GUID6 = create_guid();
	$NEW_GUID7 = create_guid();
	$NEW_GUID8 = create_guid();
	$NEW_GUID9 = create_guid();
	$NEW_GUID10 = create_guid();
	$NEW_GUID11 = create_guid();
	$NEW_GUID12 = create_guid();

?>
<!DOCTYPE html>
	<html>
	<head>
	    <title>Constructr CMS Installation</title>
	    <meta charset="UTF-8">
	    <meta name="description" content="Installation von Constructr CMS">
	    <meta name="keywords" content="Constructr CMS, phaziz.com, Christian Becher">
        <link href="../Assets/bootstrap-3.3.2-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../Assets/css/constructr.css" rel="stylesheet">
	    <style>
	    	#container
	    	{
	    		width: 65%;
	    		margin:5em auto;
	    	}
	    	a:link,
	    	a:active,
	    	a:visited
	    	{
	    		text-decoration: none;
	    		color:#444;
	    	}
	    	a:hover
	    	{
	    		text-decoration: none;
	    		color:#ff0066;
	    	}
	    	h1{font-weight: 200;}
	    </style>
	</head>
		<body>
		
			<div id="container">

<?php

if(isset($_POST['setup'])){
$NL = "\n";
$_CONFIG_FILE_CONTENT = "<?php " . $NL . "
\$_CONSTRUCTR_CONF = array " . $NL . "
( " . $NL . "
'_CONSTRUCTR_DATABASE_HOST' => '" . $_POST['db_host'] . "', " . $NL . "
'_CONSTRUCTR_DATABASE_NAME' => '" . $_POST['db_database'] . "', " . $NL . "
'_CONSTRUCTR_DATABASE_USER' => '" . $_POST['db_user'] . "', " . $NL . "
'_CONSTRUCTR_DATABASE_PASSWORD' => '" . $_POST['db_password'] . "', " . $NL . "
'_BASE_URL' => '" . $_POST['base_url'] . "', " . $NL . "
'_SESSION_CYPHER_METHOD' => MCRYPT_MODE_CBC, " . $NL . "
'_SALT' => '" . $_POST['salt1'] . "', " . $NL . "
'_SECRET' => '" . $_POST['salt2'] . "', " . $NL . "
'_CONSTRUCTR_COOKIE_LIFETIME' => '1 Hour', " . $NL . "
'_LOGGING' => true, " . $NL . "
'_TITLE' => 'CONSTRUCTR CMS', " . $NL . "
'_CONSTRUCTR_CONTACT_MAIL' => '" . $_POST['admin_email'] . "', " . $NL . "
'_TEMPLATES_DIR' => './Website-Template', " . $NL . "
'_CONSTRUCTR_BACKEND' => './Constructr', " . $NL . "
'_CONSTRUCTR_LOGFILES_PATH' => './Logfiles', " . $NL . "
'_CONSTRUCTR_LOG_ENABLED' => true, " . $NL . "
'_CONSTRUCTR_MODE' => 'development', " . $NL . "
'_CONSTRUCTR_DEBUG_MODE' => true, " . $NL . "
'_CONSTRUCTR_SESSION_NAME' => 'constructr', " . $NL . "
'_MEDIA_BASE_TITLE' => 'Media base title', " . $NL . "
'_MEDIA_BASE_COPYRIGHT' => 'Media Base copyright', " . $NL . "
'_MEDIA_BASE_DESCRIPTION' => 'Media base description', " . $NL . "
'_MEDIA_BASE_KEYWORDS' => 'Media base keywords', " . $NL . "
'_RESET_LOGIN_PASSWORD' => false, " . $NL . "
'_MAX_LOGIN_ATTEMPTS' => 5, " . $NL . "
'_LOGIN_BLOCKED_FOR' => 600, " . $NL . "
'_CREATE_STATIC' => false, " . $NL . "
'_STATIC_FILETYPE' => '.php', " . $NL . "
'_STATIC_DIR' => './Static', " . $NL . "
'_CREATE_STATIC_DOMAIN' => '', " . $NL . "
'_CREATE_DYNAMIC_DOMAIN' => '" . $_POST['base_url'] . "', " . $NL . "
'_MAGIC_GENERATION_KEY' => '" . $_POST['salt3'] . "', " . $NL . "
'_TRANSFER_STATIC' => false, " . $NL . "
'_FTP_REMOTE_HOST' => '', " . $NL . "
'_FTP_REMOTE_PORT' => 21, " . $NL . "
'_FTP_REMOTE_DIR' => '', " . $NL . "
'_FTP_REMOTE_MODE' => FTP_BINARY, " . $NL . "
'_FTP_REMOTE_USERNAME' => '', " . $NL . "
'_FTP_REMOTE_PASSWORD' => '', " . $NL . "
'_ENABLE_CONTENT_HISTORY' => false, " . $NL . "
'_CONSTRUCTR_WEBSITE_CACHE' => false, " . $NL . "
'_CONSTRUCTR_WEBSITE_CACHE_DIR' => './Website-Cache/' " . $NL . "
);";
$FILE = '../Config/constructr.conf.php';
$CREATE_CONFIG = fopen($FILE,'w+') or die ('ERROR');
fwrite($CREATE_CONFIG,trim($_CONFIG_FILE_CONTENT)) or die ('ERROR 2');
fclose($CREATE_CONFIG) or die ('ERROR 3');

echo '<div class="alert alert-success" role="alert">Konfigurationsdatei wurde geschrieben...</div>';

try{
$DBCON = new PDO('mysql:host=' . $_POST['db_host'] . ';dbname=' . $_POST['db_database'],$_POST['db_user'],$_POST['db_password'],array(PDO::ATTR_PERSISTENT => true));
$DBCON -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$QUERY = "
CREATE TABLE IF NOT EXISTS `constructr_backenduser` (
  `beu_id` int(25) NOT NULL AUTO_INCREMENT,
  `beu_username` varchar(255) COLLATE latin1_german2_ci NOT NULL,
  `beu_password` varchar(255) COLLATE latin1_german2_ci NOT NULL,
  `beu_factor` varchar(255) COLLATE latin1_german2_ci NOT NULL,
  `beu_email` varchar(255) COLLATE latin1_german2_ci NOT NULL,
  `beu_art` int(1) NOT NULL,
  `beu_last_login` datetime NOT NULL,
  `beu_active` int(1) NOT NULL,
  UNIQUE KEY `beu_id` (`beu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `constructr_backenduser_rights` (
  `cbr_id` int(25) NOT NULL AUTO_INCREMENT,
  `cbr_right` int(11) NOT NULL,
  `cbr_value` int(1) NOT NULL DEFAULT '0',
  `cbr_user_id` int(25) NOT NULL,
  `cbr_info` text NOT NULL,
  PRIMARY KEY (`cbr_id`),
  UNIQUE KEY `cbr_id` (`cbr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `constructr_config` (
  `constructr_config_id` int(20) NOT NULL AUTO_INCREMENT,
  `constructr_config_expression` varchar(200) NOT NULL,
  `constructr_config_value` varchar(200) NOT NULL,
  PRIMARY KEY (`constructr_config_id`),
  UNIQUE KEY `constructr_config_id` (`constructr_config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `constructr_content` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `content_order` int(11) NOT NULL DEFAULT '0',
  `content_page_id` int(11) NOT NULL,
  `content_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `content_content` text NOT NULL,
  `content_temp_marker` int(10) NOT NULL DEFAULT '0',
  `content_active` int(11) NOT NULL DEFAULT '1',
  `content_deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `constructr_content_history` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `content_page_id` int(11) NOT NULL,
  `content_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `content_content` text NOT NULL,
  `content_content_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `constructr_media` (
  `media_id` int(255) NOT NULL AUTO_INCREMENT,
  `media_datetime` datetime NOT NULL,
  `media_file` varchar(255) NOT NULL,
  `media_originalname` varchar(255) NOT NULL,
  `media_description` text NOT NULL,
  `media_title` varchar(255) NOT NULL,
  `media_keywords` text NOT NULL,
  `media_copyright` varchar(255) NOT NULL,
  PRIMARY KEY (`media_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `constructr_pages` (
  `pages_id` int(255) NOT NULL AUTO_INCREMENT,
  `pages_mother` int(255) NOT NULL DEFAULT '0',
  `pages_level` int(255) NOT NULL DEFAULT '1',
  `pages_order` int(255) NOT NULL DEFAULT '0',
  `pages_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pages_name` varchar(255) NOT NULL DEFAULT 'PAGE_NAME',
  `pages_url` varchar(255) NOT NULL DEFAULT 'PAGE_URL',
  `pages_css` text NOT NULL,
  `pages_js` text NOT NULL,
  `pages_template` varchar(255) NOT NULL DEFAULT 'index.php',
  `pages_title` varchar(255) NOT NULL,
  `pages_description` text NOT NULL,
  `pages_keywords` text NOT NULL,
  `pages_active` int(1) NOT NULL DEFAULT '0',
  `pages_nav_visible` int(1) NOT NULL DEFAULT '1',
  `pages_temp_marker` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pages_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO constructr_backenduser SET beu_id = '1', beu_username = :USERNAME, beu_password = :PASSWORD, beu_email = :EMAIL, beu_art = :ART, beu_last_login = :LAST_LOGIN, beu_active = :ACTIVE;

INSERT INTO `constructr_backenduser_rights` (`cbr_id`, `cbr_right`, `cbr_value`, `cbr_user_id`, `cbr_info`) VALUES
(1,10,1,1 ,'Seitenverwaltung anzeigen'),
(2,11,1,1 ,'Eine neue Seite erstellen'),
(3,12,1,1 ,'Eine neue Unterseite erstellen'),
(4,13,1,1 ,'Seiten-Eigenschaften bearbeiten'),
(5,14,1,1 ,'Seiten aktivieren / deaktivieren'),
(6,15,1,1 ,'Einzelseite entfernen'),
(7,16,1,1 ,'Seiten rekursiv entfernen'),
(8,17,1,1 ,'Seiten verschieben'),
(9,20,1,1 ,'Inhaltselemente anzeigen'),
(10,21,1,1 ,'Inhaltselemente erstellen'),
(11,22,1,1 ,'Inhaltselemente bearbeiten'),
(12,23,1,1 ,'Inhaltselemente sortieren'),
(13,24,1,1 ,'Inhaltselemente aktivieren / deaktivieren'),
(14,25,1,1 ,'Inhaltselemente entfernen'),
(15,30,1,1 ,'Suchformular auf Dashboard benutzen'),
(16,31,1,1 ,'Datenbankstruktur optimieren'),
(17,40,1,1 ,'Medienverwaltung anzeigen'),
(18,41,1,1 ,'Upload in Medienverwaltung erstellen'),
(19,42,1,1 ,'Eintrag aus Medienverwaltung entfernen'),
(20,43,1,1 ,'Medienverwaltung - Detailansicht anzeigen'),
(21,44,1,1 ,'Mülleimer anzeigen'),
(22,45,1,1 ,'Medieneinträge aus Mülleimer entfernen'),
(23,50,1,1 ,'Templates anzeigen'),
(24,51,1,1 ,'Templates bearbeiten'),
(25,52,1,1 ,'Templates entfernen'),
(26,53,1,1 ,'Templates erstellen'),
(27,66,1,1 ,'Benutzerverwaltung anzeigen'),
(28,60,1,1 ,'Benutzer entfernen'),
(29,69,1,1 ,'Benutzer aktivieren / deaktivieren'),
(30,68,1,1 ,'Benutzer bearbeiten'),
(31,67,1,1 ,'Benutzer anlegen'),
(32,70,1,1 ,'Website-Cache entfernen'),
(33,80,1,1 ,'Benutzerrechte anzeigen'),
(34,81,1,1 ,'Benutzerrechte bearbeiten'),
(35,90,1,1 ,'Constructr Plugins anzeigen'),
(36,100,1,1 ,'Statische Internetseiten generieren'),
(37,1000,1,1 ,'Systemverwaltung anzeigen');";

$STMT = $DBCON -> prepare($QUERY);
$USERNAME = trim($_POST['admin_username']);
$PASSWORD = crypt(trim($_POST['admin_password']),$_POST['salt1']);
$EMAIL = filter_var(trim($_POST['admin_email'],FILTER_VALIDATE_EMAIL));
$ART = 0;
$ACTIVE = 1;
$STMT -> execute(array(':USERNAME' => $USERNAME,':PASSWORD' => $PASSWORD,':EMAIL' => $EMAIL,':ART' => $ART,':LAST_LOGIN' => '0000-00-00 00:00:00',':ACTIVE' => $ACTIVE));
}catch (PDOException $e){
die('<div class="alert alert-danger" role="alert">Fehler bei der Datenbankverbindung - Bitte Daten &uuml;berpr&uuml;fen (' . $e . ')!</div>');
}
echo '<div class="alert alert-success" role="alert">Datenbank wurde eingerichtet - Sie k&ouml;nnen sich nun anmelden: <a href="' . $_POST['base_url'] . '/constructr/login">Constructr CMS Login</a></div>';
}
?>
				<div class="row">
					<div class="col-md-12" style="text-align:center;">
				  		<h1>ConstructrCMS</h1>
				  		<h3>Installation</h3>
					</div>
				</div>
				<br><br>
				<form class="form-horizontal" action="index.php" method="post" enctype="application/x-www-form-urlencoded" autocomplete="off">
				<input type="hidden" name="setup" value="try">
				<input type="hidden" name="salt1" id="salt1" value="<?php echo $NEW_GUID1 . $NEW_GUID2 . $NEW_GUID3 . $NEW_GUID4; ?>" required="required">
				<input type="hidden" name="salt2" id="salt2" value="<?php echo $NEW_GUID5 . $NEW_GUID6 . $NEW_GUID7 . $NEW_GUID8; ?>" required="required">
				<input type="hidden" name="salt3" id="salt3" value="<?php echo $NEW_GUID9 . $NEW_GUID10 . $NEW_GUID11 . $NEW_GUID12; ?>" required="required">
				<div class="form-group">
					<label for="db_host" class="col-sm-2 control-label">Datenbank-Host:</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="db_host" id="db_host" size="50" required="required" value="localhost" autofocus placeholder="Host der Datenbank">
						<small><span id="helpBlock" class="help-block">Zum Beispiel: <em><strong>localhost</strong></em></span></small>
					</div>
				</div>				
				<div class="form-group">
					<label for="db_database" class="col-sm-2 control-label">Datenbank-Name:</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="db_database" id="db_database" size="50" required="required" placeholder="Name der Datenbank">
						<small><span id="helpBlock" class="help-block">Der Name der vorhandenen Datenbank - zum Beispiel: <em><strong>constructrcms</strong></em></span></small>
					</div>
				</div>				
				<div class="form-group">
					<label for="db_user" class="col-sm-2 control-label">Datenbank-Benutzer:</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="db_user" id="db_user" size="50" required="required" placeholder="Datenbank-Benutzername">
						<small><span id="helpBlock" class="help-block">Der Name des vorhandenen Benutzers für die Datenbank.</span></small>
					</div>
				</div>				
				<div class="form-group">
					<label for="db_password" class="col-sm-2 control-label">Datenbank-Passwort:</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="db_password" id="db_password" size="50" required="required" placeholder="Datenbank-Passwort">
						<small><span id="helpBlock" class="help-block">Das Passwort des vorhandenen Benutzers für die Datenbank.</span></small>
					</div>
				</div>				
				<div class="form-group">
					<label for="base_url" class="col-sm-2 control-label">Basis-URL:</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="base_url" id="base_url" value="<?php echo getCurrentUrl(); ?>" size="50" required="required" placeholder="Basis-URL der Installation">
						<small><span id="helpBlock" class="help-block">Die Basis-URL für das künftige Frontend deiner ConstructrCMS-Installation.</span></small>
					</div>
				</div>				
				<div class="form-group">
					<label for="admin_username" class="col-sm-2 control-label">Administrator-Benutzername:</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="admin_username" id="admin_username" value="" size="50" required="required" placeholder="Benutzername Administrator Account">
						<small><span id="helpBlock" class="help-block">Der gewünschte Benutzername für das Backend von deinem ConstructrCMS.</span></small>
					</div>
				</div>				
				<div class="form-group">
					<label for="admin_password" class="col-sm-2 control-label">Administrator-Passwort:</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="admin_password" id="admin_password" value="" size="50" required="required" placeholder="Passwort Administrator Account">
						<small><span id="helpBlock" class="help-block">Das gewünschte Passwort für das Backend von deinem ConstructrCMS.</span></small>
					</div>
				</div>				
				<div class="form-group">
					<label for="admin_email" class="col-sm-2 control-label">Administrator-eMail:</label>
					<div class="col-sm-10">
						<input class="form-control" type="email" name="admin_email" id="admin_email" value="" size="50" required="required" placeholder="eMail Administrator Account">
						<small><span id="helpBlock" class="help-block">Die gewünschte eMail-Adresse für das Administrator-Account.</span></small>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" style="text-align:center;">
					  	<input class="btn btn-primary btn-lg" type="submit" value="ConstructrCMS installieren">
					</div>
				</div>
				</form>
				<br><br><br><br>
				<div class="row">
					<div class="col-md-12" style="text-align:center;">
				  		<p><small>ConstructrCMS von <a href="http://phaziz.com">phaziz.com</a></small></p>
					</div>
				</div>
			</div>
            <script src="../Assets/jquery-1.11.2.min.js"></script>
            <script src="../Assets/bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
            <script>
            	$(function(){
					var ACT_URL = window.location.href;
					ACT_URL = ACT_URL.replace('/CONSTRUCTR-CMS-SETUP/index.php','');
					$('#base_url').val(ACT_URL);
            	});
            </script>
		</body>
	</html>