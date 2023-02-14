<?php
// (c)RedSky

  $check = array($_GET, $_POST, $_COOKIE);
  
  foreach($check as &$data)
  {
    if(empty($data) !== true)
    {
      if(count($data) > 100) 
      {
        die();
      }
      
      foreach($data as $key => &$value)
      {
        if(isset($key{51}) !== false or ctype_alnum(strtr($key, array('_' => ''))) !== true)
        {
          die();
        }
        
        if(empty($value) !== true)
        {
          if(is_array($value) !== false)
          {
            die();
          }

          if(isset($value{200}) !== false)
          {
            $end = substr($value, -100);
            if(preg_match('![^\./?]+!', $end) !== 1)
            {
              die();
            }
            unset($end);
          }
          
          $value = strtr($value, array(chr(0x2e).chr(0x2e).chr(0x2f) => null, chr(0x2e).chr(0x2f) => null, chr(0x00) => null));
        }
      }
    }
  }
  
  $_GET    = $check[0];
  $_POST   = $check[1];
  $_COOKIE = $check[2];

  unset($check);

?>