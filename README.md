# ACE | GDLE Account Registration Script

PHP account registration script for ACE and GDLE servers.

![Screenshot](https://i.imgur.com/ocIhSj2.png "ACEmulator Account Registration Script")

Features:

- Bootstrap 3 design with Jquery 1.11.3
- Choose between ACE or GDLE servers
- Limit accounts by unique IP address
- Optional proxy and VPN protection via IPQualityScore.com (free account)
- Ability to blacklist individual email providers
- Google reCaptcha v2 (free account required)
- Email verification through PHPMailer (TLS encryption)
- Sets the account Access Level for successful email validations
- Full form validation using both Javascript and PHP for maximum flexibility and security
- Option to use BCRYPT or SHA512 for password hashes
- The form uses ajax to serialize and submit all the data
- Error messages display on the same page as the form using Bootstrap alerts
- Registration terms of service popup with required check box
- Alertify script used in place of html modal for terms of service
- Only accepts valid characters for usernames and automatically removes spaces from passwords
- Password reset form so players never have to worry about losing their password again
- Top navigation menu with activated links

Requirements:

- PHP 7.2+
- Google reCaptcha v2 keys

Recommended:

- SSL encrypted website
- IPQualityScore.com account

Installation:

1) Edit /inc/db.php with your database information.

2) Edit /config.php with the relevant information.

3) Find and replace the default Google reCaptcha Site Key in 3 files: /index.php, /forgot_password.php, and /reset.php with your own. (the Site Key is different than the Secret key located in the config file)

Example: `<div class="" data-sitekey="ENTER YOUR RECAPTCHA SITE KEY HERE"></div>`

4) Upload the entire script and all directories to your website or a folder of your choosing.

5) Visit yoursite.com/db/update.php to update your database account(s) table automatically. You should see the message "Successfuly updated accounts table" if successful.

ACE:

6) Set the emulator to ACE and use_BCRYPT to TRUE in /config.php
7) Edit your ACE Server Config.js file and change the PasswordHashWorkFactor to "10". Set AllowAutoAccountCreation to "false". 

GDLE(default):

6) Set the emulator to GDLE and use_BCRYPT to FALSE in /config.php
7) Edit your GDLE server.cfg file and set auto_create_accounts to 0.

Access the registration form at yourdomain.com.

Optional:

This script has the option to block proxy/vpn registrations via ipqualityscore.com. A free account is fine unless you're getting more than a thousand registrations per month. To enable proxy protection edit /config.php and set proxy_protection to TRUE and enter your ipqualityscore key.

Note:

This form uses a randomized "Authentication Token" to validate email addresses which is stored in the database. If a user fails to validate their email then this token will remain in the database until they successfully validate.
