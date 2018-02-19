
authImage
===========

What is it ?
------------

So, let's say you own a website and you've got a simple contact form. Everyday you get tons of emails from spam scripts and you want to stop it. What you need is a clever mechanism, which will tell apart human from a machine. The best way, and very popular one, is to use an image with special code drawn on it. Humans can read it, machines cannot. But probably you don't know how or don't have the time to write it ? Don't worry, I have done it for you :).

What will you need ?
--------------------

PHP with a support for GD library and... that's all. No database needed ? Nope, it does not keep any records, create files, whatsoever. So how does it work you ask ? Don't, it just do ;) Of course if you're so curious, you can see the code for yourself.

How to use it ?
---------------

You have no idea how simple it is. You need to write only few lines of code! So, let's implement a simple html form and a php file to validate it. Firstofall you need to create a script to generate an image. You do it with only 3 lines of code (see image.php):

``` php
<?
  require('class.authImage.php');
  $ai = new authImage();
  $ai->createImage();
?> 
```

Next you need to create a simple form (see index.html):

``` html
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2">
<meta name="Author" CONTENT="Cezary Piekacz :: Cezex">
<meta http-equiv="Reply-to" CONTENT="cezex@redfish.DELETETHIS.pl">
<title>authImage Class</title>
<meta name="Description" CONTENT="authImage Class">
</head>
<body>
<form method="POST" action="validate.php">
Enter code from the image below:<br />
<input type="text" name="auth_code" size="6" maxlength="6">
<img src="image.php" width="100" height="30"><br /><br />
<input type="submit" value="Validate code">
</form>
</body>
</html> 
```

Finaly, the validation file to check if data entered in a form is done by user or a script: 

``` php
<?
  require('class.authImage.php');
  $ai = new authImage();
  if ($ai->validateAuthCode($_POST[auth_code])) {
    echo 'Entered code is correct.';
  }
  else {
    echo 'Entered code is incorrect.';
  }
?> 
```

And that's all, you're done! If you have any suggestions for a new version just send me an e-mail. 

Contact
-------

* cpiekacz@gmail.com
* https://twitter.com/cezex

Licence
-------

authImage is available under the MIT license.

Copyright © 2006 Cezary Piekacz

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.