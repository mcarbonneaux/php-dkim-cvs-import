<?

// DKIM example and test

// Basic configuration of the test programes

$to='dkim-test@testing.dkim.org, check-auth@verifier.port25.com, test@dkimtest.jason.long.name' ;
$sender='eric@vyncke.org' ;
$subject='Test of PHP-DKIM' ;
$body="<h1>Congratulations</h1>
You have installed and configured PHP-DKIM correctly!" ;

// Nothing to configure below

require 'dkim.php' ;

BuildDNSTXTRR() ;

$headers="From: \"Fresh DKIM Manager\" <$sender>\r\n".
	"To: $to\r\n".
	"Reply-To: $sender\r\n".
	"Content-Type: text/html\r\n".
	"MIME-Version: 1.0" ;
$headers = AddDKIM($headers,$subject,$body) . $headers;

// Some Unix MTA has a bug and add redundant \r breaking some DKIM implementation
// Based on your configuration, you may want to comment the next line
$headers=str_replace("\r\n","\n",$headers) ; 

$result=mail($to,$subject,$body,$headers,"-f $sender") ;
if (!$result)
	die("Cannot send email to $to") ;

?>