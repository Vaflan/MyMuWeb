<?PHP
// This Script from MuWeb 0.8
// By =Master=
// Cut by Vaflan

/*
  Parameters of form elem that are being processed by the class
$elem = array (
   'name'      => string,  // all
   'type'      => string,  // text or select
                           // text covers html types: text, textarea, hidden, password 
                           // select covers html types: select, checkbox and radio
   'label'     => string,  // field label ( eg. 'Phone number' )
   'required'  => boolean, // field must have value
   'cont'      => string,  // content type: email, word, alpha, digit
   'ereg'      => string,  // text, textarea
   'preg'      => string,  // text, textarea
   'len'       => integer, // accurate length
   'len_min'   => integer, // min length
   'len_max'   => integer, // max length
   'val_max'   => integer, // max value of an integer ( use with cont == digit )
   'val_min'   => integer, // min value of an integer ( use with cont == digit )
   'values'    => array;   // select accepted values
   'forbid'    => array;   // forbidden values that match other criteria
   'arr_size_min' => integer // when field name is an array( eg. 'phones[]' ) 
                           // minimum number of elements in array
   // Fields dependencies

   
   'eqal'      => mixed,   // array or string, 
                           // value of this field must be equal to value of field in array() 
								   // eg. in when there are two password boxes either array or string
   'with'      => mixed,   // array or string, value must exist with other value(s)
   'alt_or'    => mixed,   // array or string, at least one of fields must have a value
   'alt_xor'   => mixed   // array or string, only one field must have a value
);
*/
class FormValidator {
	
	/**
	 * Form definition
	 * 
	 * @var array
	 * @access private
	 */
	var $elems = array();
	
	/**
	 * If error occured while validation
	 * 
	 * @var boolean
	 * @access private
	 */
	var $err = false;
	
	/**
	 * Validation status for each field
	 * 
	 * @var array
	 * @access private
	 */
	var $validElems = array();
	
	/**
	 * Fields that need dependency check
	 * 
	 * @var array
	 * @access private
	 */
	var $secPhase = array();
	
	
	/**
	 * Constructor
	 *
	 * @param mixed $elems form definition
	 * @access public
	 * @return void
	 */
	function FormValidator(&$elems) {
		if ( is_array($elems) ) {
			// hmm...
			is_array($elems[0]) ? $this->elems = $elems : $this->elems[] = $elems;
		}
	}
	
	
	/**
	 * Validates Form
	 *
	 * @param array $request - $_GET, $_POST, $_SESSION or other data
	 * @access public
	 * @return boolean true - validation OK, false - validation error
	 */
	function validate(&$request) {
		
		// validated elems
		$this->validElems = array();
		
		$this->err = false;
		
		// fields that needs dependency check
		$this->secPhase = array();
			
		
		foreach ( $this->elems as $e ) {
			$name = $e['name'];
			
			isset($e['label']) ? null : $e['label'] = null;
			
			// Field not present in html form
			if ( !isset($request[$name]) ) {
				$this->_setError($name); continue;
			}
			
			$val = $request[$name];
			
			// If field name is an array ( eg. phones[] in example above )
			if ( is_array($val) ) {
				if ( !empty($e['arr_size_min']) && $e['arr_size_min'] > 0 ) {
					$c = 0;
					foreach($val as $v) {
						if ( !empty($v) ) {
							$c++;
						}
					}
					if ( $c < $e['arr_size_min'] ) {
						$this->_setError($name); continue;
					}
				}
			}
			// Each value is converted to an array
			else {
				$val = array($val);
			}
			
				
			foreach ( $val as $k => $v ) {
				if ( $e['required'] == true && empty($v) ) { 
					$this->_setError($name, $k, $v, $e['label']);
					//$this->validElems[$name][$k] = array($v, false);
					continue;
				}
				elseif ( empty($v) ) {
					
					$e['validated'] = true;
					$this->validElems[$name][$k] = array($v,true);
					continue;
				}
								
					
				if ( in_array($e['type'], array('text')) ) {
					if ( !empty($e['len']) && $e['len'] != strlen($v) ) {
						$this->_setError($name, $k, $v, $e['label']); continue;
					}
					if ( !empty($e['len_min']) && strlen($v) < $e['len_min'] ) {
						$this->_setError($name, $k, $v, $e['label']); continue;	
					}
					if ( !empty($e['len_max']) && strlen($v) > $e['len_max'] ) {
						$this->_setError($name, $k, $v, $e['label']); continue;
					} 
					if ( !empty($e['val_min']) && $v < $e['val_min'] ) {
						$this->_setError($name, $k, $v, $e['label']); continue;
					}
					if ( !empty($e['val_max']) && $v > $e['val_max'] ) {
						$this->_setError($name, $k, $v, $e['label']); continue;
					}
					if ( !empty($e['ereg']) && !ereg($e['ereg'], $v) ) {
						$this->_setError($name, $k, $v, $e['label']); continue;
					}
					if ( !empty($e['preg']) && !preg_match($e['preg'], $v) ) {
						$this->_setError($name, $k, $v, $e['label']); continue;
					}
					
					if ( !empty($e['forbid']) && in_array($v, $e['forbid']) ) {						
						$this->_setError($name, $k, $v, $e['label']); continue;
						
					}
					
					if ( isset($e['cont']) && in_array($e['cont'], array('email', 'alpha', 'word', 'digit')) ) {
						$expr = ''; // just temporally
						// digits only
						if ( $e['cont'] == 'digit' ) {
							$expr = "/^\d*$/";
						}
						// email verify
						elseif ( $e['cont'] == 'email' ) {
							if ( !$this->verifyEmail($v) ) { 	
								$this->_setError($name, $k, $v, $e['label']); continue;
							}
						}
						elseif ( $e['cont'] == 'alpha' ) {
							$expr = "/^[a-zA-Z0-9\_\-]*$/";
						}
						elseif ( $e['cont'] == 'word' ) {
							$expr = "/^\w*$/";
						}
						
						
						// del first condition when class would be complete...
						if ( !empty($expr) && !preg_match($expr, $v) ) {
							$this->_setError($name, $k, $v, $e['label']); continue;
						}
					}
					
					if ( !empty($e['with'])   ) {
						$this->secPhase[] = $e;
					}

					if ( !empty($e['equal']) ) {						
						$this->secPhase[] = $e;
					}
					
					foreach ( array('with', 'equal', 'alt_or', 'alt_xor') as $eq ) {
						if ( !empty($e[$eq]) ) {
							$this->secPhase[] = $e;
							break;
						}
					}
				}
				elseif ( $e['type'] == 'select' ) {
					if ( isset($e['values']) && !in_array($v, $e['values'])  ) {
						$this->_setError($name, $k, $v, $e['label']); continue;
					}
					
					foreach ( array('with', 'equal', 'alt_or', 'alt_xor') as $eq ) {
						if ( !empty($e[$eq]) ) {
							$this->secPhase[] = $e;
							break;
						}
					}
					
				}
				// hmm...
				else {
					$this->_setError($name, $k, $v, $e['label']); continue;
					
				}
				
				$this->validElems[$name][$k] = array($v,true);
			}
			
		}
		
		
		$this->_validateSecondPhase($request);
		return $this->err;
	}


	
	/*
	 * Dependency check
	 *
	 * @param array array $request - $_GET, $_POST, $_SESSION or other data
	 * @access private
	 * @return void
	 */
	function _validateSecondPhase(&$request) {
		foreach ( $this->secPhase as $e ) {
			$name = $e['name'];
			$val = $request[$name];
			
			if ( !is_array($val) ) {
				$val = array($val);
			}
			
			
			foreach ( $val as $k => $v) {
			
				if ( isset($e['with']) && is_array($e['with']) ) {
					foreach ($e['with'] as $eq) {
						if ( !empty($v) && empty($this->validElems[$eq][$k][0]) ) {
							$this->_setError($eq, $k, $v, $e['label']); 
							continue;
						}	
					}
				}
				elseif ( !empty($e['with']) && !empty($v) && empty($this->validElems[$e['with']][$k][0])  ) {
					$this->_setError($e['with'], $k, $v, $e['label']); continue;
				}

				
				if ( isset($e['equal']) && is_array($e['equal']) ) {
					foreach ( $e['equal'] as $eq ) {
						if ( $v != $this->validElems[$eq][$k][0] ) {
							$this->_setError($name, $k, $v, $e['label']); continue;
						}
					}
				}
				elseif ( !empty($e['equal']) && $v != $this->validElems[$e['equal']][$k][0] ) {
					$this->_setError($name, $k, $v, $e['label']); continue;
				}
				
				
				if ( isset($e['alt_or']) && is_array($e['alt_or']) && empty($v) ) {
					$c = 0;
					foreach ( $e['alt_or'] as $eq ) {
						 empty($this->validElems[$e['alt_or']][$k][0]) ? $c++ : null;
					}
					if ( $c == 0 ) {
						$this->_setError($name, $k, $v, $e['label']); continue;
					}
				}
				elseif ( !empty($e['alt_or']) && empty($v) && empty($this->validElems[$e['alt_or']][$k][0]) ) {
					$this->_setError($e['with'], $k, $v, $e['label']); continue;
				}
				
				
				if ( isset($e['alt_xor']) && is_array($e['alt_xor']) ) {
					$c = 0;
					foreach ( $e['alt_xor'] as $eq ) {
						empty($this->validElems[$e['alt_xor']][$k][0]) ? null : $c++;
					}
					
					if ( empty($v) && $c != 1 ) {
						$this->_setError($e['with'], $k, $v, $e['label']); continue;
					}
					elseif ( !empty($v) && $c > 0 ) {
						$this->_setError($e['with'], $k, $v, $e['label']); continue;
					}
				}
				elseif ( !empty($e['alt_xor']) ) {
					if ( empty($v) && empty($this->validElems[$e['alt_xor']][$k][0]) ) {
						$this->_setError($e['with'], $k, $v, $e['label']); continue;
					}
					elseif ( !empty($v) && !empty($this->validElems[$e['alt_xor']][$k][0]) )  {
						$this->_setError($e['with'], $k, $v, $e['label']); continue;
					}
				}
				
				
			}
		}
	}
	
	
	/**
	 * Email verification
	 * 
	 * @param string $email
	 * @access private
	 * @return boolean true if OK otherwise false
	 */
	function verifyEmail($email) {
		$expr = '/^(.+)@(([a-z0-9\.-]+)\.[a-z]{2,5})$/i';
		$uexpr = "/^[a-z0-9\~\!\#\$\%\&\(\)\-\_\+\=\[\]\;\:\'\"\,\.\/]+$/i";
		if (preg_match($expr, $email, $regs)) {
			$username = $regs[1];
			$host = $regs[2];
			//if (checkdnsrr($host, MX)) {
				if (preg_match($uexpr, $username)) {
					return true;
				} 
				else {
					return false;
				}
			//} 
			//else {
			//	return false;
			//}
		} 
		else {
			return false;
		}
	}
	
	
	/**
	 * WARNING !
	 * Function name will be changed in future releases
	 *
	 * Highlight field/text with Smarty - if you don't use smarty it's quite useless...
	 *
	 * 
	 * @param object $s - Smarty object
	 * @param string $class_name - a css class name to assign
	 * @access public
	 * @return void
	 */
	function assignErrorClass() {
		foreach ( $this->validElems as $k => $v ) {
			
			foreach ( $v as $k1 => $v1) {
					echo $v[name];
				if ( $v1[1] === false ) {
					$err_c[] = $v1[0];
					
				}

			}

		}
		
		//$s->assign('err_c', $err_c);
	return $err_c;
	}
	
	/**
	 * WARNING !
	 * Function name may be changed in future releases
	 *
	 * Setting error
	 * 
	 * @param string $name field name
	 * @param integer $k key value usually 0 until field name is an array ( eg. phones[])
	 * @param string $value field value
	 * @param string $label - field label
	 * @access private
	 * @return void
	 */
	function _setError($name, $k=0, $value = '', $label = '') {
					
		$this->validElems[$name][$k] = array($value, false, $label);
		$this->err = true;
	}
	
	/**
	 * get array with validation result
	 * 
	 * @access public
	 * @return array - array with validation result for each field
	 */
	function getValidElems() {
		return $this->validElems;	
	}
}


?>