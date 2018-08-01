<?php 
session_start();
session_regenerate_id();
if(!isset($_SESSION['user']))      // if there is no valid session
{
    header("Location: /");
	session_write_close();
} else {
//	echo "Logged in as: " . $_SESSION['user'] . "<br />";
	session_write_close();
}
require 'vendor/autoload.php';

$name = $_SESSION['user'] . "@education.vic.gov.au"; 
$pass = $_SESSION['password'];
$ldapServer = 'services.education.vic.gov.au';
$ldapSchoolNo = explode(" - ", $_POST['school']);
$ldapSchool = 'CN=' . $ldapSchoolNo[1] . "-gs-Specialist Technician";
$ldapBase = $ldapSchool . ',OU=School Groups,OU=Central,DC=services,DC=education,DC=vic,DC=gov,DC=au';
// Construct new Adldap instance.
$ad = new \Adldap\Adldap();

// Create a configuration array.
$config = [
    'account_suffix'        => '@education.vic.gov.au',
    'domain_controllers'    => ['education.vic.gov.au'],
    'port'                  => 389,
    'base_dn'               => 'ou=Corporate,OU=Users,ou=Schools,dc=education,dc=vic,dc=gov,dc=au',
    'admin_username'        => $_SESSION['user'],
    'admin_password'        => $_SESSION['password'],
    'follow_referrals'      => true,
    'use_ssl'               => false,
    'use_tls'               => false,
    'use_sso'               => false,
];

// Create a new connection provider.
$provider = new \Adldap\Connections\Provider($config);
// Add the provider to Adldap.
$ad->addProvider('default', $provider);
// Call the search() method on provider instance:
$search = $provider->search()->select(['mail', 'samaccountname', 'givenname', 'sn']);
// Try to connect to the server
$ldapConn = ldap_connect($ldapServer);
if (!$ldapConn)
{
  die('Cannot Connect to LDAP server');
}
// Bind
$ldapBind = ldap_bind($ldapConn,$name,$pass);
if (!$ldapBind)
{
  die('Cannot Bind to LDAP server');
}

// Set the ldap options
ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);

// Search the LDAP server
$ldapSearch = ldap_search($ldapConn, $ldapBase, "(member=*)",array('member'));
$ldapResults = ldap_get_entries($ldapConn, $ldapSearch);

for ($item = 0; $item < $ldapResults['count']; $item++)
{
  for ($attribute = 0; $attribute < $ldapResults[$item]['count']; $attribute++)
  {
   $data = $ldapResults[$item][$attribute];
		for ($technician = 0; $technician < $ldapResults[$item][$data]['count']; $technician++)
		{
			$st_dn = $ldapResults[$item][$data][$technician];
			try {
				// Connect using the providers alias name.
				$ad->connect('default');

				// Perform a query.
				$user = $search->findByDn($st_dn);
				
				$username = $user->getAttribute('samaccountname');
				$email = $user->getAttribute('mail');
				$firstName = $user->getAttribute('givenname');
				$lastName = $user->getAttribute('sn');
				
				echo '<b>' . $firstName[0] . " " . $lastName[0] . " " . "</b><br />";
				echo '<a class="btn btn-primary btn-sm" href=mailto:' . $email[0] . '>';
				echo '<i class="fa fa-envelope fa-2x fa-fw"></i></a>&nbsp;';	
				echo '<a class="btn btn-primary btn-sm" href=sips:' . $email[0] . '>';
				echo '<i class="fa fa-skype fa-2x fa-fw"></i></a>';
				echo '<br />';
			} catch (\Adldap\Exceptions\Auth\BindException $e) {
				die("Can't bind to LDAP server!");
			}
		}
  }
  echo '<hr />';
}

function clean($string) {
   //$string = str_replace(' ', ' ', $string); // Replaces all spaces with spaces
   return preg_replace('/[^A-Za-z0-9\]/', '', $string); // Removes special chars.
}


/////////////////////////////////////////////////
/////////////////////////////////////////////////
/////////////////////////////////////////////////
?>