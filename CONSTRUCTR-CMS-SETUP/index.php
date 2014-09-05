<?php

	require_once('../Config/constructr_user_rights.conf.php');

	// 2014-09-05
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
	    <style>
	    	#container
	    	{
	    		width: 70%;
	    		margin:5em auto;
				font-family:'Helvetica Neue', Helvetica, Arial, Verdana, sans-serif;
	    		font-size:12px;
	    		color:#444;
	    		font-weight:300;
	    	}
	    	table
	    	{
	    		margin: 0 auto;
	    	}
	    	table,
	    	td,
	    	th
	    	{
	    		border: 1px solid #666;
	    		padding: 10px 10px 10px 10px;
	    	}
	    	th,
	    	td
	    	{
	    		min-width: 200px;
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
	    </style>
	</head>
		<body>
		
			<div id="container">

				<?php

					/*
					 * POSTPROCESSING INSTALLATION CONSTRUCTR CMS START
					 * */
					 if(isset($_POST['setup']))
					 {
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
'_CREATE_DYNAMIC_DOMAIN' => '', " . $NL . "
'_MAGIC_GENERATION_KEY' => '" . $_POST['salt3'] . "', " . $NL . "
'_TRANSFER_STATIC' => false, " . $NL . "
'_FTP_REMOTE_HOST' => '', " . $NL . "
'_FTP_REMOTE_PORT' => 21, " . $NL . "
'_FTP_REMOTE_DIR' => '', " . $NL . "
'_FTP_REMOTE_MODE' => FTP_BINARY, " . $NL . "
'_FTP_REMOTE_USERNAME' => '', " . $NL . "
'_FTP_REMOTE_PASSWORD' => '', " . $NL . "
'_CONSTRUCTR_WEBSITE_CACHE' => false, " . $NL . "
'_CONSTRUCTR_WEBSITE_CACHE_DIR' => './Website-Cache/' " . $NL . "
);";

			                $FILE = '../Config/constructr.conf.php';
			                $CREATE_CONFIG = fopen($FILE,'w+') or die ('ERROR');
		                    fwrite($CREATE_CONFIG,trim($_CONFIG_FILE_CONTENT)) or die ('ERROR 2');
		                    fclose($CREATE_CONFIG) or die ('ERROR 3');

							echo '<p style="color:green;">Konfigurationsdatei wurde geschrieben...</p>';
							
							// EINRICHTUNG DER DATENBANK
						    try
						    {
						        $DBCON = new PDO('mysql:host=' . $_POST['db_host'] . ';dbname=' . $_POST['db_database'],$_POST['db_user'],$_POST['db_password'],array(PDO::ATTR_PERSISTENT => true));
						        $DBCON -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
								
			                    $QUERY = "
CREATE TABLE IF NOT EXISTS `constructr_backenduser` (
  `beu_id` int(25) NOT NULL AUTO_INCREMENT,
  `beu_username` varchar(255) COLLATE latin1_german2_ci NOT NULL,
  `beu_password` varchar(255) COLLATE latin1_german2_ci NOT NULL,
  `beu_email` varchar(255) COLLATE latin1_german2_ci NOT NULL,
  `beu_art` int(1) NOT NULL,
  `beu_last_login` datetime NOT NULL,
  `beu_active` int(1) NOT NULL,
  UNIQUE KEY `beu_id` (`beu_id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `constructr_backenduser_rights` (
  `cbr_id` int(25) NOT NULL AUTO_INCREMENT,
  `cbr_right` int(11) NOT NULL,
  `cbr_value` int(1) NOT NULL DEFAULT '0',
  `cbr_user_id` int(25) NOT NULL,
  `cbr_info` text NOT NULL,
  PRIMARY KEY (`cbr_id`),
  UNIQUE KEY `cbr_id` (`cbr_id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `constructr_config` (
  `constructr_config_id` int(20) NOT NULL AUTO_INCREMENT,
  `constructr_config_expression` varchar(200) NOT NULL,
  `constructr_config_value` varchar(200) NOT NULL,
  PRIMARY KEY (`constructr_config_id`),
  UNIQUE KEY `constructr_config_id` (`constructr_config_id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `constructr_content` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `content_order` int(11) NOT NULL DEFAULT '0',
  `content_page_id` int(11) NOT NULL,
  `content_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `content_content` text NOT NULL,
  `content_temp_marker` int(10) NOT NULL DEFAULT '0',
  `content_active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`content_id`),
  UNIQUE KEY `content_id` (`content_id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `constructr_content_history` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `content_page_id` int(11) NOT NULL,
  `content_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `content_content` text NOT NULL,
  `content_content_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`content_id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `constructr_media` (
  `media_id` int(255) NOT NULL AUTO_INCREMENT,
  `media_datetime` datetime NOT NULL,
  `media_file` varchar(255) NOT NULL,
  `media_originalname` varchar(255) NOT NULL,
  `media_exif` text NOT NULL,
  PRIMARY KEY (`media_id`),
  UNIQUE KEY `media_id` (`media_id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `constructr_pages` (
  `pages_id` int(20) NOT NULL AUTO_INCREMENT,
  `pages_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pages_name` varchar(100) NOT NULL DEFAULT 'PAGE_NAME',
  `pages_url` varchar(255) NOT NULL DEFAULT 'PAGE_URL',
  `pages_template` varchar(50) NOT NULL DEFAULT 'index.php',
  `pages_title` varchar(255) NOT NULL,
  `pages_description` text NOT NULL,
  `pages_keywords` text NOT NULL,
  `pages_lft` int(100) NOT NULL DEFAULT '0',
  `pages_rgt` int(100) NOT NULL DEFAULT '0',
  `pages_active` int(1) NOT NULL DEFAULT '0',
  `pages_nav_visible` int(1) NOT NULL DEFAULT '1',
  `pages_temp_marker` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pages_id`)
) ENGINE=MyISAM;

INSERT INTO constructr_backenduser SET beu_id = '1', beu_username = :USERNAME, beu_password = :PASSWORD, beu_email = :EMAIL, beu_art = :ART, beu_last_login = :LAST_LOGIN, beu_active = :ACTIVE;

INSERT INTO `constructr_backenduser_rights` (`cbr_id`, `cbr_right`, `cbr_value`, `cbr_user_id`, `cbr_info`) VALUES
(1,1,1,10 ,'Seitenverwaltung anzeigen'),
(2,1,1,11 ,'Eine neue Seite erstellen'),
(3,1,1,12 ,'Eine neue Unterseite erstellen'),
(4,1,1,13 ,'Seiten-Eigenschaften bearbeiten'),
(5,1,1,14 ,'Seiten aktivieren / deaktivieren'),
(6,1,1,15 ,'Einzelseite entfernen'),
(7,1,1,16 ,'Seiten rekursiv entfernen'),
(8,1,1,17 ,'Seiten verschieben'),
(9,1,1,20 ,'Inhaltselemente anzeigen'),
(10,1,1,21 ,'Inhaltselemente erstellen'),
(11,1,1,22 ,'Inhaltselemente bearbeiten'),
(12,1,1,23 ,'Inhaltselemente sortieren'),
(13,1,1,24 ,'Inhaltselemente aktivieren / deaktivieren'),
(14,1,1,25 ,'Inhaltselemente entfernen'),
(15,1,1,30 ,'Suchformular auf Dashboard benutzen'),
(16,1,1,31 ,'Datenbankstruktur optimieren'),
(17,1,1,40 ,'Medienverwaltung anzeigen'),
(18,1,1,41 ,'Upload in Medienverwaltung erstellen'),
(19,1,1,42 ,'Eintrag aus Medienverwaltung entfernen'),
(20,1,1,43 ,'Medienverwaltung - Detailansicht anzeigen'),
(21,1,1,44 ,'Mülleimer anzeigen'),
(22,1,1,45 ,'Medieneinträge aus Mülleimer entfernen'),
(23,1,1,50 ,'Templates anzeigen'),
(24,1,1,51 ,'Templates bearbeiten'),
(25,1,1,52 ,'Templates entfernen'),
(26,1,1,53 ,'Templates erstellen'),
(27,1,1,66 ,'Benutzerverwaltung anzeigen'),
(28,1,1,60 ,'Benutzer entfernen'),
(29,1,1,69 ,'Benutzer aktivieren / deaktivieren'),
(30,1,1,68 ,'Benutzer bearbeiten'),
(31,1,1,67 ,'Benutzer anlegen'),
(32,1,1,70 ,'Website-Cache entfernen'),
(33,1,1,80 ,'Benutzerrechte anzeigen'),
(34,1,1,81 ,'Benutzerrechte bearbeiten'),
(35,1,1,90 ,'Constructr Plugins anzeigen'),
(36,1,1,100 ,'Statische Internetseiten generieren'),
(37,1,1,1000 ,'Systemverwaltung anzeigen');
			                    ";			                    

			                    $STMT = $DBCON -> prepare($QUERY);

					            $USERNAME = trim($_POST['admin_username']);
					            $PASSWORD = crypt(trim($_POST['admin_password']),$_POST['salt1']);
					            $EMAIL = filter_var(trim($_POST['admin_email'],FILTER_VALIDATE_EMAIL));
					            $ART = 0;
					            $ACTIVE = 1;

			                    $STMT -> execute( 
			                        array
			                        (
			                            ':USERNAME' => $USERNAME,
			                            ':PASSWORD' => $PASSWORD,
			                            ':EMAIL' => $EMAIL,
			                            ':ART' => $ART,
			                            ':LAST_LOGIN' => '0000-00-00 00:00:00',
			                            ':ACTIVE' => $ACTIVE
			                        )
			                    );

						    }
						    catch (PDOException $e)
						    {
								die('<p style="color:red">Fehler bei der Datenbankverbindung - Bitte Daten &uuml;berpr&uuml;fen (' . $e . ')!</p>');
						    }
							// EINRICHTUNG DER DATENBANK


							echo '<p style="color:green;">Datenbank wurde eingerichtet - Sie k&ouml;nnen sich nun anmelden: <a href="' . 'http://' . $_SERVER['HTTP_HOST'] . '/constructr/login">Constructr CMS Login</a></p><br><br><br><br><br>';
	                    }

				?>

				<h3>Constructr CMS Installation</h3>
				<br><br>
				<form action="index.php" method="post" enctype="application/x-www-form-urlencoded" autocomplete="off">
				<input type="hidden" name="setup" value="try">
				<strong>Datenbank-Informationen</strong><br><br>
				Datenbank-Host:<br><input type="text" name="db_host" id="db_host" size="50" required="required" value="localhost" autofocus><br><br>
				Datenbank:<br><input type="text" name="db_database" id="db_database" size="50" required="required"><br><br>
				Datenbank-Benutzer:<br><input type="text" name="db_user" id="db_user" size="50" required="required"><br><br>
				Datenbank-Passwort:<br><input type="text" name="db_password" id="db_password" size="50" required="required"><br><br>
				<br><br><strong>System-Informationen</strong><br><br>
				URL Constructr CMS:<br><input type="text" name="base_url" id="base_url" value="<?php echo 'http://' . $_SERVER['HTTP_HOST']; ?>" size="50" required="required"><br><br>
				Sicherheits-Phrase 1:<br><input type="text" name="salt1" id="salt1" value="<?php echo $NEW_GUID1 . $NEW_GUID2 . $NEW_GUID3 . $NEW_GUID4; ?>" size="50" required="required"><br><br>
				Sicherheits-Phrase 2:<br><input type="text" name="salt2" id="salt2" value="<?php echo $NEW_GUID5 . $NEW_GUID6 . $NEW_GUID7 . $NEW_GUID8; ?>" size="50" required="required"><br><br>
				Sicherheits-Phrase 3:<br><input type="text" name="salt3" id="salt3" value="<?php echo $NEW_GUID9 . $NEW_GUID10 . $NEW_GUID11 . $NEW_GUID12; ?>" size="50" required="required"><br><br>
				<br><br><strong>Benutzer-Informationen</strong><br><br>
				Administrator Benutzername:<br><input type="text" name="admin_username" id="admin_username" value="" size="50" required="required"><br><br>
				Administrator Passwort:<br><input type="text" name="admin_password" id="admin_password" value="" size="50" required="required"><br><br>
				Administrator eMail:<br><input type="text" name="admin_email" id="admin_email" value="" size="50" required="required"><br><br>
				<br><input type="submit" value="ConstructrCMS installieren">
				</form>

			</div>

		</body>
	</html>