<?php
require_once(dirname(__FILE__) . '/bm.php');
require_once("cpaint2.config.php");

  $GLOBALS['__cpaint_bm'] = new bm();


	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
  class cpaint {
    var $version = '2.0.2';
    var $response_type;
    var $basenode;
    var $api_functions;
    var $api_datatypes;
    var $use_wsdl;
    function cpaint() {
      $this->__construct();
    }
    function __construct() {

      $this->basenode       = new cpaint_node();
      $this->basenode->set_name('ajaxResponse');
      $this->basenode->set_attribute('id', '');
      $this->basenode->set_encoding('UTF-8');
      
      $this->response_type  = 'TEXT';
      $this->api_functions  = array();
      $this->api_datatypes  = array();
      $this->use_wsdl       = true;
      
      $this->complex_type(array(
          'name'      => 'cpaintResponseType',
          'type'      => 'restriction',   // (restriction|complex|list)
          'base_type' => 'string',        // scalar type of all values, e.g. 'string', for type = (restriction|list) only
          'values'    => array(           // for type = 'restriction' only: list of allowed values
            'XML', 'TEXT', 'OBJECT', 'E4X', 'BM',
          ),
        )
      );
      $this->complex_type(array(
          'name'      => 'cpaintDebugLevel',
          'type'      => 'restriction',
          'base_type' => 'long',
          'values'    => array(
            -1, 0, 1, 2
          ),
        )
      );
      $this->complex_type(array(
          'name'      => 'cpaintDebugMessage',
          'type'      => 'list',
          'base_type' => 'string',
        )
      );
      
      $this->complex_type(array(
          'name'      => 'cpaintRequestHead',
          'type'      => 'complex',
          'struct'    => array(
            0 => array('name' => 'functionName',  'type' => 'string'),
            1 => array('name' => 'responseType',  'type' => 'cpaintResponseType'),
            2 => array('name' => 'debugLevel',    'type' => 'cpaintDebugLevel'),
          ),
        )
      );
      
      $this->complex_type(array(
          'name'      => 'cpaintResponseHead',
          'type'      => 'complex',
          'struct'    => array(
            0 => array('name' => 'success',  'type' => 'boolean'),
            1 => array('name' => 'debugger', 'type' => 'cpaintDebugMessage'),
          ),
        )
      );
      
      // determine response type
      if (isset($_REQUEST['cpaint_response_type'])) {
        $this->response_type = strtoupper((string) $_REQUEST['cpaint_response_type']);
      } // end: if
    }

    function start($input_encoding = 'UTF-8') {
      $user_function  = '';
      $arguments      = array();
      
      // work only if there is no API version request
      if (!isset($_REQUEST['api_query'])
        && !isset($_REQUEST['wsdl'])) {
        $this->basenode->set_encoding($input_encoding);
        
        if ($_REQUEST['cpaint_function'] != '') {
          $user_function  = $_REQUEST['cpaint_function'];
          $arguments      = $_REQUEST['cpaint_argument'];
        }
  
        
        foreach ($arguments as $key => $value) {
          
          if (get_magic_quotes_gpc() == true) {
            $value = stripslashes($value);
          } // end: if
          
          
          $arguments[$key] = $GLOBALS['__cpaint_bm']->parse($value);
        } // end: foreach
        
        $arguments = cpaint_transformer::decode_array($arguments, $this->basenode->get_encoding());
  
        if (is_array($this->api_functions[$user_function])
          && is_callable($this->api_functions[$user_function]['call'])) {
          // a valid API function is to be called
          call_user_func_array($this->api_functions[$user_function]['call'], $arguments);
        
        } else if ($user_function != '') {
          // desired function is not registered as API function
          $this->basenode->set_data('[CPAINT] A function name was passed that is not allowed to execute on this server.');
        }
      } // end: if
    }
    function return_data() {
      // send appropriate headers to avoid caching
      header('Expires: Fri, 14 Mar 1980 20:53:00 GMT');
      header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
      header('Cache-Control: no-cache, must-revalidate');
      header('Pragma: no-cache'); 
      header('X-Powered-By: CPAINT v' . $this->version . '/PHP v' . phpversion());
      
      // work only if there is no API version request
      
      if (!isset($_REQUEST['api_query']) 
        && !isset($_REQUEST['wsdl'])) {
        // trigger generation of response
        switch (trim($this->response_type)) {
  
          case 'TEXT':
            header('Content-type: text/plain; charset=' . cpaint_transformer::find_output_charset($this->basenode->get_encoding()));
            echo cpaint_transformer::toString($this->basenode);
            break;
          
          case 'BM':
            header('Content-type: text/plain; charset=' . cpaint_transformer::find_output_charset($this->basenode->get_encoding()));
            echo cpaint_transformer::toBM($this->basenode);
            break;
               
          case 'OBJECT':
          case 'E4X':
          case 'XML':
            header('Content-type:  text/xml; charset=' . cpaint_transformer::find_output_charset($this->basenode->get_encoding()));
            echo '<?xml version="1.0" encoding="' . cpaint_transformer::find_output_charset($this->basenode->get_encoding()) . '"?>' 
                . cpaint_transformer::toXML($this->basenode);
            break;
  
          default:
            echo 'ERROR: invalid response type \'' . $this->response_type . '\'';
        } // end: switch
      
      } elseif (isset($_REQUEST['api_query'])) {
        // API version request
        header('Content-type: text/plain; charset=ISO-8859-1');
        echo 'CPAINT v' . $this->version . '/PHP v' . phpversion();
      
      } elseif ($this->use_wsdl == true
        && isset($_REQUEST['wsdl'])) {
        
        if (is_file(dirname(__FILE__) . '/cpaint2.wsdl.php')
          && is_readable(dirname(__FILE__) . '/cpaint2.wsdl.php')) {
          
          require_once(dirname(__FILE__) . '/cpaint2.wsdl.php');
          
          if (class_exists('cpaint_wsdl')) {
            // create new instance of WSDL library
            $wsdl = new cpaint_wsdl();

            // build WSDL info
            header('Content-type: text/xml; charset=UTF-8');
            echo $wsdl->generate($this->api_functions, $this->api_datatypes);

          } else {
            header('Content-type: text/plain; charset=ISO-8859-1');
            echo 'WSDL generator is unavailable';
          } // end: if
        
        } else {
          header('Content-type: text/plain; charset=ISO-8859-1');
          echo 'WSDL generator is unavailable';
        } // end: if
      } // end: if
    }
    
   
    function register($func, $input = array(), $output = array(), $comment = '') {
      $return_value = false;
      $input        = (array)   $input;
      $output       = (array)   $output;
      $comment      = (string)  $comment;
      
      if (is_array($func)
        && (is_object($func[0]) || is_string($func[0]))
        && is_string($func[1])
        && is_callable($func)) {
        
        // calling a method of an object
        $this->api_functions[$func[1]] = array(
          'call'    => $func,
          'input'   => $input,
          'output'  => $output,
          'comment' => $comment,
        );
        $return_value = true;
        
      } elseif (is_string($func)) {
        // calling a standalone function
        $this->api_functions[$func] = array(
          'call'    => $func,
          'input'   => $input,
          'output'  => $output,
          'comment' => $comment,
        );
        $return_value = true;
      } // end: if
      
      return $return_value;
    }
    
    function unregister($func) {
      $retval = false;
      
      if (is_array($this->api_functions[$func])) {
        unset($this->api_functions[$func]);
      } // end: if
    
      return $retval;
    }
         
       function complex_type($schema) {
      $return_value = false;
      $schema       = (array)   $schema;
      
      if ($schema['name'] != ''
        && in_array($schema['type'], array('restriction', 'complex', 'list'))) {
        
        $this->api_datatypes[] = $schema;
        $return_value          = true;
      } // end: if
    
      return $return_value;
    }
    
   
    function use_wsdl($state) {
      $this->use_wsdl = (boolean) $state;
    }
    
  
    function &add_node($nodename, $id = '') {
      return $this->basenode->add_node($nodename, $id);
    }

   
    function set_data($data) {
      $this->basenode->set_data($data);
    }
  
    function get_data() {
      return $this->basenode->get_data();
    }
    
   
    function set_id($id) {
      $this->basenode->set_attribute('id', $id);
    }
    
  
    function get_id() {
      return $this->basenode->get_attribute('id');
    }
    
    
    function set_attribute($name, $value) {
      $this->basenode->set_attribute($name, $value);
    }
    
   
    function get_attribute($name) {
      return $this->basenode->get_attributes($name);
    }
    
   
    function set_name($name) {
      $this->basenode->set_name($name);
    }

        function get_name() {
      return $this->basenode->get_name();
    }
    
    
    
   
    function get_response_type() {
      return $this->response_type;
    }
    
  }
  
 
  class cpaint_node {
   
    var $composites;
    
   
    var $attributes;

    
    var $nodename;

    
    var $data;

    
    var $input_encoding;

    
    function cpaint_node() {
      $this->__construct();
    }
    
   
    function __construct() {
      // initialize properties
      $this->composites     = array();
      $this->attributes     = array();
      $this->data           = '';
      
      $this->set_encoding('UTF-8');
      $this->set_name('');
      $this->set_attribute('id', '');
    }

    
    function &add_node($nodename, $id = '') {
      $composites = count($this->composites);

      
      $this->composites[$composites] =& new cpaint_node();
      $this->composites[$composites]->set_name($nodename);
      $this->composites[$composites]->set_attribute('id', $id);
      $this->composites[$composites]->set_encoding($this->input_encoding);

      return $this->composites[$composites];
    }

   
    function set_data($data) {
      $this->data = $data;
    }
    
    
    function get_data() {
      return $this->data;
    }
    
   
    function set_id($id) {
      if ($id != '') {
        $this->set_attribute('id', $id);
      } // end: if
    }
    
  
    function get_id() {
      return $this->get_attribute('id');
    }
    
    
    function set_attribute($name, $value) {
      $this->attributes[$name] = (string) $value;
    }
    
       function get_attribute($name) {
      return $this->attributes[$name];
    }
    
    
    function set_name($name) {
      $this->nodename = (string) $name;
    }

    
    function get_name() {
      return $this->nodename;
    }
  
    
    function set_encoding($encoding) {
      $this->input_encoding = strtoupper((string) $encoding);
    }
  
   
    function get_encoding() {
      return $this->input_encoding;
    }
  }
  
 
  class cpaint_transformer {
    
    function toString(&$node) {
      $return_value = '';

      foreach ($node->composites as $composite) {
        $return_value .= cpaint_transformer::toString($composite);
      }

      $return_value .= cpaint_transformer::encode($node->get_data(), $node->get_encoding());

      return $return_value;
    }
    
  
    function toXML(&$node) {
      $return_value = '<' . $node->get_name();
      
      // handle attributes
      foreach ($node->attributes as $name => $value) {
        if ($value != '') {
          $return_value .= ' ' . $name . '="' . $node->get_attribute($name) . '"';
        }
      } // end: foreach
      
      $return_value .= '>';

      // handle subnodes    
      foreach ($node->composites as $composite) {
        $return_value .= cpaint_transformer::toXML($composite);
      }

      $return_value .= cpaint_transformer::encode($node->get_data(), $node->get_encoding())
                    . '</' . $node->get_name() . '>';

      return $return_value;
    }
    
    
    function toBM($node) {
      $return_value = '';
      $BM_node    = new stdClass();

      
      $BM_node->attributes = $node->attributes;      

     
      foreach ($node->composites as $composite) {
        
        if (!is_array($BM_node->{$composite->nodename})) {
          $BM_node->{$composite->nodename} = array();
        } 
        
        
        $BM_node->{$composite->nodename}[] = $GLOBALS['__cpaint_bm']->parse(cpaint_transformer::toBM($composite));
      }

      
      $BM_node->data = $node->data;
      
      return $GLOBALS['__cpaint_bm']->stringify($BM_node);
    }
    
   
    function encode($data, $encoding) {
      // convert string
      if (function_exists('iconv')) {
        
        $return_value = iconv($encoding, 'UTF-8', $data);

      } elseif ($encoding == 'ISO-8859-1') {
        
        $return_value = utf8_encode($data);

      } else {
       
        $return_value = $data;
      }       
      
      for ($i = 0; $i < 32; $i++) {
        $return_value = str_replace(chr($i), '\u00' . sprintf('%02x', $i), $return_value);
      } 
      
      // encode <, >, and & respectively for XML sanity
      $return_value = str_replace(chr(0x26), '\u0026', $return_value);
      $return_value = str_replace(chr(0x3c), '\u003c', $return_value);
      $return_value = str_replace(chr(0x3e), '\u003e', $return_value);
      
      return $return_value;
    }
  
   
    function decode($data, $encoding) {
      
      
      if (is_string($data)) {
        if (function_exists('iconv')) {
          
          $return_value = iconv('UTF-8', $encoding, $data);
  
        } elseif ($encoding == 'ISO-8859-1') {
          
          $return_value = utf8_decode($data);
  
        } else {
          
          $return_value = $data;
        } 
      
      } else {
        
        $return_value = $data;
      } 
      
      return $return_value;
    }

    
    function decode_array($data, $encoding) {
      $return_value = array();
    
      foreach ($data as $key => $value) {

        if (!is_array($value)) {
          $return_value[$key] = cpaint_transformer::decode($value, $encoding);

        } else {
          $return_value[$key] = cpaint_transformer::decode_array($value, $encoding);
        }
      }

      return $return_value;
    }
    
   
    function find_output_charset($encoding) {
      $return_value = 'UTF-8';
    
      if (function_exists('iconv')
        || $encoding == 'UTF-8'
        || $encoding == 'ISO-8859-1') {
        
        $return_value = 'UTF-8';

      } else {
        $return_value = $encoding;
      } // end: if
      
      return $return_value;
    }
  }
 
?>