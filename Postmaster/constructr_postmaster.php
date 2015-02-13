<?php

/**
 * 	Constructr CMS - a Slim-PHP-Framework based Content Management System
 * 
 * 	Built with:
 * 	Slim-PHP-Framework (http://www.slimframework.com/)
 * 	Bootstrap Frontend Framework (http://getbootstrap.com/)
 * 	PHP PDO (http://php.net/manual/de/book.pdo.php)
 *  jQuery (http://jquery.com/)
 *  ckEditor (http://ckeditor.com/)
 *	Codemirror (http://codemirror.net/)
 * 	...
 * 
 *	LICENCE 
 * 
 *  DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 *  Version 1, February 2015
 *	Copyright (C) 2015 Christian Becher | phaziz.com <christian@phaziz.com>
 *  Everyone is permitted to copy and distribute verbatim or modified
 *  copies of this license document, and changing it is allowed as long
 *  as the name is changed.
 *
 *  DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 *  TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 *  0. YOU JUST DO WHAT THE FUCK YOU WANT TO!
 *
 *  Visit http://constructr-cms.org
 * 	Visit http://blog.phaziz.com/category/constructr-cms/
 *  Visit http://phaziz.com
 * 
 * 
 * @author Christian Becher | phaziz.com <phaziz@gmail.com>
 * @copyright 2015 Christian Becher | phaziz.com
 * @license DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 * @version 1.04.3
 * @link http://constructr-cms.org/
 * @package ConstructrCMS
 * 
 */

    if(isset($_GET['constructr_postmaster']) && $_GET['constructr_postmaster'] != '')
    {
        $SPAM = false;

        if(preg_match( "/bcc:|cc:|multipart|\[url|Content-Type:/i", implode($_GET)))
        {
            $SPAM = true;
        }

        if(preg_match_all("/<a|http:/i", implode($_GET), $out) > 3)
        {
            $SPAM = true;
        }

        if($SPAM == false)
        {
            if(isset($_GET['postmaster_datetime']) && is_numeric($_GET['postmaster_datetime']))
            {
                $SENDED = intval($_GET['postmaster_datetime']);
                $DIF = (time() - $SENDED);

                if ($DIF > 10 || $DIF < 36000)
                {
                    if($_GET['postmaster_guid'] != '')
                    {
                        $_MAILTEXT = date('d.m.Y, H:i:s') . " Uhr\n\n";

                        foreach($_GET AS $_GETTER_KEY => $_GETTER_VALUE)
                        {
                            if(stristr($_GETTER_VALUE,"[link=") || stristr($_GETTER_VALUE,"[url="))
                            {
                                 die();
                            }

                            $_MAILTEXT .= $_GETTER_KEY . ': ' . $_GETTER_VALUE . "\n";
                        }

                        @mail($_CONSTRUCTR_CONF['_CONSTRUCTR_CONTACT_MAIL'],'eMail ' . $_CONSTRUCTR_CONF['_BASE_URL'],$_MAILTEXT);
                    }
                }
            }
        }
    }
    else if(isset($_POST['constructr_postmaster']) && $_POST['constructr_postmaster'] != '')
    {
        $SPAM = false;

        if(preg_match( "/bcc:|cc:|multipart|\[url|Content-Type:/i", implode($_POST)))
        {
            $SPAM = true;
        }

        if(preg_match_all("/<a|http:/i", implode($_POST), $out) > 3)
        {
            $SPAM = true;
        }

        if($SPAM == false)
        {
            if(isset($_POST['postmaster_datetime']) && is_numeric($_POST['postmaster_datetime']))
            {
                $SENDED = intval($_POST['postmaster_datetime']);
                $DIF = (time() - $SENDED);

                if ($DIF > 10 || $DIF < 36000)
                {
                    if($_POST['postmaster_guid'] != '')
                    {
                        $_MAILTEXT = date('d.m.Y, H:i:s') . " Uhr\n\n";

                        foreach($_POST AS $_POSTER_KEY => $_POSTER_VALUE)
                        {
                            if(stristr($_POSTER_VALUE,"[link=") || stristr($_POSTER_VALUE,"[url="))
                            {
                                 die();
                            }

                            $_MAILTEXT .= $_POSTER_KEY . ': ' . $_POSTER_VALUE . "\n";
                        }

                        @mail($_CONSTRUCTR_CONF['_CONSTRUCTR_CONTACT_MAIL'],'eMail ' . $_CONSTRUCTR_CONF['_BASE_URL'],$_MAILTEXT);
                    }
                }
            }
        }
    }
