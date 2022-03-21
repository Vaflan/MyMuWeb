<?PHP
// MuWeb Anti-SQL Injection

function check_inject() 
  { 
    $badchars = array(";","'","*","/"," \ ","DROP", "SELECT", "UPDATE", "DELETE", "WHERE", "drop", "select", "update", "delete", "where", "-1", "-2", "-3","-4", "-5", "-6", "-7", "-8", "-9", "distinct", "having", "truncate", "replace", "handler", "like", "procedure", "limit", "order by", "group by"); 
   
    foreach($_POST as $value) 
    { 
	$value = clean_variable($value);

	if(in_array($value, $badchars)) 
      { 
        die("<b><font color=red>SQL Injection Detected - Make sure only to use letters and numbers!</font>\n<br>\nIP: ".$_SERVER['REMOTE_ADDR']."</b>"); 
      } 
      else 
      { 
        $check = preg_split("//", $value, -1, PREG_SPLIT_OFFSET_CAPTURE); 
        foreach($check as $char) 
        { 
          if(in_array($char, $badchars)) 
          { 
            die("<b><font color=red>SQL Injection Detected - Make sure only to use letters and numbers!</font>\n<br>\nIP: ".$_SERVER['REMOTE_ADDR']."</b>"); 
          } 
        } 
      } 
    } 
  } 
function clean_variable($var) { 
	$newvar = preg_replace('/[^a-zA-Z0-9\_\-]/', '', $var); 
	return $newvar; 
}
check_inject();






// Clean Var Edited by Vaflan

function clean_var($var) {
 $var = stripslashes($var);
 $newvar = str_replace("\n","",$var);
 //$newvar = str_replace(";","&#59;",$newvar);
 //$newvar = str_replace("%","&#37;",$newvar);
 $newvar = str_replace("'","&#39;",$newvar);
 $newvar = str_replace(",","&#44;",$newvar);
 $newvar = str_replace(".","&#46;",$newvar);
 //$newvar = str_replace(":","&#58;",$newvar);
 $newvar = str_replace("`","&#96;",$newvar);
 return $newvar;
}






// Onter Anti-SQL Injection from MuWeb.org

function xw_sanitycheck($str){ 
    if(strpos(str_replace("''","","$str"),"'")!=false)
        return str_replace("'", "''",$str); 
    else 
        return $str; 
} 

function secure($str){ 
    // Case of an array 
    if (is_array($str)) { 
        foreach($str AS $id => $value) { 
            $str[$id] = secure($value); 
        } 
    } 
    else 
        $str = xw_sanitycheck($str); 

    return $str; 
} 

// Get Filter 
$xweb_AI    = array_keys($_GET); 
$i=0; 
while($i<count($xweb_AI)) { 
    $_GET[$xweb_AI[$i]]=secure($_GET[$xweb_AI[$i]]); 
    $i++; 
} 
unset($xweb_AI); 

// Request Filter 
$xweb_AI    = array_keys($_REQUEST); 
$i=0; 
while($i<count($xweb_AI)) { 
    $_REQUEST[$xweb_AI[$i]]=secure($_REQUEST[$xweb_AI[$i]]); 
    $i++; 
} 
unset($xweb_AI); 

// Post Filter 
$xweb_AI    = array_keys($_POST); 
$i=0; 
while($i<count($xweb_AI)) { 
    $_POST[$xweb_AI[$i]]=secure($_POST[$xweb_AI[$i]]); 
    $i++; 
} 

// Cookie Filter (do we have a login system?) 
$xweb_AI    = array_keys($_COOKIE); 
$i=0; 
while($i<count($xweb_AI)) { 
    $_COOKIE[$xweb_AI[$i]]=secure($_COOKIE[$xweb_AI[$i]]); 
    $i++; 
} 
// End 
?>