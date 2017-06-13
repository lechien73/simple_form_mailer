# Shever's Form Mailer

## What does it do?

This is a simple PHP file to provide an easy way to receive the contents of a web form. It also integrates with Google reCaptcha. The contents of the form will be emailed to the an address you supply.

## Setting up Shever's Form Mailer

### Without reCaptcha

If you are not using reCaptcha, then the form mailer will work out of the box with no additional set up parameters.

To help against spamming, you can add the destination email address into mail.php rather than having it as a hidden form field. To do this (recommended) add the email address on line 46, so for example:
```
recipient = "example@mattrudge.net"
```

### With reCaptcha

If you are using Google's reCaptcha service, then you will need to: 

1. Supply your secret key. Paste your secret key into line 20. If you don't already have a secret key, then you can make one here [https://www.google.com/recaptcha/admin](https://www.google.com/recaptcha/admin).

2. Choose which reCaptcha library you want to use.

The older method is to [download recaptchalib.php](https://storage.googleapis.com/google-code-archive-downloads/v2/code.google.com/recaptcha/recaptcha-php-1.11.zip) and place it in the same directory on your server as mail.php.

Make sure line 16 is set as follows:
```
$reCaptcha_version = 1;
```

Then change line 18 to:
```
require_once "recaptchalib.php"
```

The recommended method is to use Composer to select the correct reCaptcha library to use. The instructions are contained here: [https://github.com/google/recaptcha](https://github.com/google/recaptcha).

You will then need to change line 16 to either point to your Composer autoload.php file, or your manually created autoload.php file.

Then set line 16 as follows:
```
$reCaptcha_version = 2;
```

### Setting up your form

Your form needs to have its action set to mail.php, as follows:

```
<form action="/mail.php" method="post" name="Send">
```

You also need to have the following required hidden fields:
```
<input type="hidden" name="subject" value="Contact Form" />
<input type="hidden" name="success_page" value="/success.html" />
```
It is important that tne names of these inputs are correct. The subject value determines the subject of the email when it is sent. The success_page value is a link to the page that the user will be redirected to when the form has been mailed successfully.

The following hidden fields are optional:
```
<input type="hidden" name="error_page" value="/fail.html" />
<input type="hidden" name="recipient" value="example@mattrudge.net" />
```

The error_page value specifies where the user will be redirected if there is an error. If no value is supplied, then error.html will be used by default.

The recipient value specifies the destination of the email. I recommend that you override this by putting the email address in the recipient variable on line 46, as mentioned above.

## Contributing

Feel free to fork the repository and create a pull request. This code is released under the GNU [General Public License](http://www.gnu.org/licenses/gpl.html). This means that you are free to use the software for personal or commercial use. You are free to change it and redistribute it on the condition that it too is released under the GPL and that your modifications are added to the comment block at the top. Use this software at your own risk, the author holds no liability for any loss or damage howsoever caused.

