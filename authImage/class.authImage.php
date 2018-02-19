<?
  /**************************************************************
  
    authImage PHP class
    version 0.4

    Author:       Cezary Piekacz :: Cezex
    Release date: 2006-09-20
    Last update:  2008-05-27
    License:      GPL, http://www.gnu.org/copyleft/gpl.html
    
    For more information visit: http://redfish.pl/apps/authimage
    
  ***************************************************************/

  class authImage {

    // BEGIN CONFIGURATION
    // **************************************************************
    
    // Unique password for better encryption, enter whatever you like    
    
    var $uniqPasswd = 's@#dsf33@#d';

    // Cookie name, enter whatever you like    
    
    var $cookieName = 'AuthImageCode';
    
    // Length of the generated code
    
    var $codeLength = 3;
    
    // Font properties
    
    var $font       = Array(
                        'path'     => './verdana.ttf',
                        'minSize'  => 10,
                        'maxSize'  => 14,
                        'minAngle' => -10,
                        'maxAngle' => 10,
                      );
    
    // Width and heigh of created image
    
    var $width      = 100;
    var $height     = 30;
    
		// Background color

		var $bgColor    = Array(255, 255, 255);
		var $transparentBg = false;
		
    // **************************************************************
    // END CONFIGURATION

		// Set image background color; You can use an array [red, green, blue],
		// hex code: "#000000", or rgb value: "red,green,blue"
		// to set background color as transparent set second parameter to true
		
		function setBgColor($color, $transparent = false) {
			if (is_array($color))
				$this->bgColor = $color;
			
			elseif (preg_match('/^#([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})$/i', $color, $match))
				$this->bgColor = Array(hexdec($match[1]), hexdec($match[2]), hexdec($match[3]));

			elseif (preg_match('/^([0-9]{3}), *([0-9]{3}), *([0-9]{3})$/i', $color, $match))
				$this->bgColor = Array(hexdec($match[1]), hexdec($match[2]), hexdec($match[3]));

			if ($transparent == true)
				$this->transparentBg = true;
		}
		
    // Create random text used in validation process

    function createRandomText() {
	  return rand(1,9) . '+' . rand(1,9);
    }
    
		// Encrypt generated code

    function cipherCode($code) {
      return md5($code . $this->uniqPasswd);
    }
    
		// Create authentication code and save it in cookie

    function createAuthCode() {
      $code = $this->createRandomText();
	  preg_match('/(\d+)\+(\d+)/', $code, $m);
  
      SetCookie($this->cookieName, $this->cipherCode($m[1]+$m[2]));
    
      return $code;
    }

		// Check authentication code and destroy the cookie

    function validateAuthCode($code) {

      $cookie_code = $_COOKIE[$this->cookieName];
      SetCookie($this->cookieName, '', time() - 1);
      
      if (strcmp($cookie_code, $this->cipherCode(strtolower($code))) == 0)
				return true;
			
			else
				return false;
    }

		// Create an image with authentication code

    function createImage() {
      $code = $this->createAuthCode();
  
      // Make image expire as soon as it is displayed
      
      header('Content-type:image/png'); 
      header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
      header('Cache-Control: no-store, no-cache, must-revalidate'); 
      header('Cache-Control: post-check=0, pre-check=0', false);

      $img     = ImageCreate($this->width, $this->height);
      $bgColor = ImageColorAllocate($img, $this->bgColor[0], $this->bgColor[1], $this->bgColor[2]);
      
      // Fill background with white colour
      
      ImageFill ($img, 1, 5, $bgColor); 
      
      // Draw an authentication code composed of numbers and letters
      
      for ($i = 0; $i < strlen($code); $i++) {
				do {
					$newcolor = Array(rand(0,255), rand(0, 255), rand(0, 255));
					$color = ImageColorAllocate($img, $newcolor[0], $newcolor[1], $newcolor[2]);
				} while ( ($newcolor[0] > $this->bgColor[0] - 50) && ($newcolor[0] < $this->bgColor[0] + 50) &&
									($newcolor[1] > $this->bgColor[1] - 50) && ($newcolor[1] < $this->bgColor[1] + 50) &&
									($newcolor[2] > $this->bgColor[2] - 50) && ($newcolor[2] < $this->bgColor[2] + 50) );
      
        ImageTTFText(
          $img,
          rand($this->font['minSize'], $this->font['maxSize']),         // font size
          rand($this->font['minAngle'], $this->font['maxAngle']),       // angle
          ($this->font['maxSize'] / 3) + ($i * $this->font['maxSize']), // x
          rand($this->font['maxSize'] + ($this->font['maxSize'] / 3), $this->height - ($this->font['maxSize'] / 3)),
                                                                        // y
          $color,                                                       // color
          $this->font['path'],                                          // font
          $code[$i]                                                     // text
        );

      }

			if ($this->transparentBg)
				imagecolortransparent($img, $bgColor);
		
      ImagePNG($img);
      ImageDestroy($img);
    }
    
  }
?>
