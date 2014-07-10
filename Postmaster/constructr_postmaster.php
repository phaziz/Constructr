<?php

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
