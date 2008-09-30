<?

// Uncomment the $open_SSL_pub and $open_SSL_priv variables and
// copy and paste the content of the public- and private-key files INCLUDING
// the first and last lines (those starting with ----)

//$open_SSL_pub="-----BEGIN PUBLIC KEY-----
//... copy & paste your public key
//-----END PUBLIC KEY-----" ;

//$open_SSL_priv="" ;

// DKIM Configuration

// Domain of the signing entity (i.e. the email domain)
// This field is mandatory
$DKIM_d='example.com' ;  

// Default identity 
// Optional (can be left commented out), defaults to no user @$DKIM_d
//$DKIM_i='@vyncke.org' ; 

// Selector, defines where the public key is stored in the DNS
//    $DKIM_s._domainkey.$DKIM_d
// Mandatory
$DKIM_s='test' ;

?>