<?php
require("class.phpmailer.php");

class MyMailer extends PHPMailer {
    // Set default variables for all new objects
    var $From     = "etevaldojales@gmail.com";
    var $FromName = "Sistema - Cabra Forte";
    var $Host     = "cabraforte.com.br";
    var $Mailer   = "smtp"; 
    var $SMTPAuth = false;
    var $Username = "etevaldojales@gmail.com";
    var $Password = "J1l2s315966@";
    var $Port     = "587";
	                         // Alternative to IsSMTP()
    var $WordWrap = 75;

    // Replace the default error_handler
    function error_handler($msg) {
        print("My Site Error");
        print("Description:");
        printf("%s", $msg);
        exit;
    }

    // Create an additional function
    function do_something($something) {
        // Place your new code here
    }
}	 
?>