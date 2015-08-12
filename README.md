<html>
<head>
<title>PHP-DKIM README</title>
</head>
<body lang="en">
<h1>PHP Implementation of DKIM</h1>
<h2>Installation</h2>
<ol>
<li>Simply copy <b>dkim.php</b> and <b>dkim-cfg-dist.php</b> to the same directory as the PHP
files of your application. 
<li>Rename <b>dkim-cfg-dist.php</b> into <b>dkim-cfg.php</b> and configure it (see below)
</ol>
<h2>Configuration</h2>
While DKIM relies on cryptographic signatures, it is quite easy to configure but it requires the
use of <b>OpenSSL</b> on the command line (from your web server or on any platform).
<ol>
<li>Generate the RSA private key (in the example key size if 384 bits which is very small and not
very secure but it makes the DNS step easier):<pre>
openssl genrsa -out key.priv 384
</pre>
<li>Generate the RSA public key from the new RSA private key:<pre>
openssl rsa -in key.priv -pubout > key.pub
</pre>
<li>Copy and paste the private & public keys into <b>dkim-cfg.php</p> in PHP variables $open_SSL_priv and
$open_SSL_pub (<i>note: this means that your private key is readable to anybody able to read <b>dkim-cfg.php</b>)
<li>Configure the remaining items in <b>dkim-cfg.php</b>:
	<ul>
	<li><b>$DKIM_d</b>: this your email domain
	<li><b>$DKIM_s</b>: the selector, you can choose anything there (respecting the DNS syntax -- like
	no white space), it allows you to have several DKIM signers/servers for the same email domain
	</ul>
<li>You now have to configure the DNS zone file of your domain. The easiest is to have a look into
<b>dkim-test.php</b> and call the function <b>BuildDNSTXTRR()</b> from the command line (or through the web). The
exact content of a DNS resource record (RR) of type TXT (mandatory) is displayed and must be entered
into your zone file. Depending on your DNS server settings, you may have to wait minutes or hours before the change
is propagated world-wide.
<li>That's all Folks ;-)
</ol>

<h2>Using PHP-DKIM</h2>
Again, the <b>dkim-test.php</b> file contains an example of sending email with PHP-DKIM. The 
test email is sent to DKIM testing reflectors, this is your email will bounce with the status
of your DKIM signature.<p>
The basic PHP-DKIM usage for an HTML e-mail is:<pre>
$sender='john@example.com' ;
$headers="From: \"Fresh DKIM Manager\" &lt;$sender&gt>\r\n".
	"To: $to\r\n".
	"Reply-To: $sender\r\n".
	"Content-Type: text/html\r\n".
	"MIME-Version: 1.0" ;
$headers = AddDKIM($headers,$subject,$body) . $headers;

$result=mail($to,$subject,$body,$headers,"-f $sender") ;
</pre>
The core function is <b>AddDKIM</b> which generates the <b>DKIM-Signature:</b>
heading (which must preceede the other headers)).
<h2>Caveats</h2>
Some Message Transfer Agent (MTA) like sendmail, postfix, qmail, ... are sometimes
changing the headers with operations such as:
<ul>
<li>adding a \r in front of each \n (then it is useless to separate the mail() headings
with a \r\n as the MTA will translate them into \r\r\n and some DKIM canonicalization
will choke with the additional \r
<li>remove the " which are often used as braces around a full name in the To:
or From: heading
</ul>
Therefore, it is advised to use <b>dkim-test.php</b> to send test DKIM emails
to the various on-line email reflectors to test how your MTA behaves and
then adjust how you specify the headers.
<hr>
<em>Last update September 2008, Eric Vyncke <a href=mailto:eric@vyncke.org>eric at vyncke dot org</a>.</em>
</body>
</html>
