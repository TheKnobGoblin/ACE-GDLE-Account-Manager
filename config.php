<?php

if(count(get_included_files()) ==1) exit("Direct access not permitted.");

// ACE or GDLE supported
$emulator = "GDLE";

// Set to true for ACE servers, false for GDLE servers
$use_BCRYPT = false;

// Number of accounts allowed per unique IP address
$ipLimit = 3;

// Access level granted upon successful email verification
$access_level = 1;

// Google reCaptcha v2 secret key
$recaptcha_secret = 'ENTER YOUR RECAPTCHA SECRET HERE';

// Enable proxy/vpn protection? Requires a free ipqualityscore.com account
$proxy_protection = false;
$ipqualityscore_key = 'ENTER YOUR IPQUALITYSCORE.COM KEY HERE';

// SMTP TLS settings
$admin_email = 'admin@domain.com';
$admin_name = 'Admin';
$email_host = 'domain.com';
$email_password = '';
$email_port = '587';

// Blacklisted email providers
$blacklist = array(
	'protonmail.com',
	'tutanota.com',
	'guerrillamail.com',
	'secure-email.org'
);

?>