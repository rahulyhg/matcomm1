<?php

  class BM {
   
    var $at = 0;
    
   
    var $ch = ' ';
    
  
    var $text = '';
    
   
    function stringify($arg) {
      $returnValue  = '';
      $c            = '';
      $i            = '';
      $l            = '';
      $s            = '';
      $v            = '';
      $numeric      = true;

      switch (gettype($arg)) {

        case 'array':
          // do a test whether all array keys are numeric
          foreach ($arg as $i => $v) {
            if (!is_numeric($i)) {
              $numeric = false;
              break;
            }
          }
          
          if ($numeric) {
            
            foreach ($arg as $i => $v) {
              if (strlen($s) > 0) {
                $s .= ',';
              }
                          
              $s .= $this->stringify($arg[$i]);
            } // end: foreach
                      
            $returnValue = '[' . $s . ']';
          
          } else {
            // associative array
            foreach ($arg as $i => $v) {
              if (strlen($s) > 0) {
                $s .= ',';
              }
              $s .= $this->stringify($i) . ':' . $this->stringify($arg[$i]);
            }
            // return as object
            $returnValue = '{' . $s . '}';
          }
          break;
          
        case 'object':
          
          foreach (get_object_vars($arg) as $i => $v) {
            $v = $this->stringify($v);
                           
            if (strlen($s) > 0) {
              $s .= ',';
            }
                           
            $s .= $this->stringify($i) . ':' . $v;
          }
                    
          $returnValue = '{' . $s . '}';
          break;
            
        case 'integer':
        case 'double':
          $returnValue = is_numeric($arg) ? (string) $arg : 'null';
          break;
            
        case 'string':
          $l = strlen($arg);
          $s = '"';
                
          for ($i = 0; $i < $l; $i++) {
            $c = $arg{$i};
                    
            if (ord($c) >= ord(' ')) {
                        
              if ($c == '\\' 
                || $c == '"') {
                            
                $s .= '\\';
              }
              $s .= $c;
                    
            } else {
                        
              switch ($c) {
                            
                case '\b':
                  $s .= '\\b';
                  break;
                            
                case '\f':
                  $s .= '\\f';
                  break;
                            
                case '\n':
                  $s .= '\\n';
                  break;
                            
                case '\r':
                  $s .= '\\r';
                  break;
                            
                case '\t':
                  $s .= '\\t';
                  break;
                            
                default:
                  $s .= '\u00' . sprintf('%02x', ord($c));
              }
            }
          }
          $returnValue = $s . '"';
          break;
          
        case 'boolean':
          $returnValue = (string) $arg;
          break;
          
        default:
          $returnValue = 'null';
      }
      
      return $returnValue;
    }
    
 
    function parse($text) {
      $this->at  = 0;
      $this->ch  = ' ';
      $this->text  = $text;
      
      return $this->val();
    }
    
 
    function error($m) {
      trigger_error($m . ' at offset ' . $this->at . ': ' . $this->text, E_USER_ERROR);
    }

    function next() {
      $this->ch = $this->text{$this->at};
      $this->at++;
      return $this->ch;
    }

   
    function white() {
    
      while ($this->ch != '' 
        && ord($this->ch) <= ord(' ')) {

        $this->next();
      }
    }

 
    function str() {
      $i = '';
      $s = '';
      $t = '';
      $u = '';

      if ($this->ch == '"') {

        while ($this->next() !== null) {
                    
          if ($this->ch == '"') {
            $this->next();
            return $s;
                    
          } elseif ($this->ch == '\\') {
                        
            switch ($this->next()) {
              case 'b':
                $s .= '\b';
                break;
                          
              case 'f':
                $s .= '\f';
                break;
                          
              case 'n':
                $s .= '\n';
                break;
                          
              case 'r':
                $s .= '\r';
                break;
                          
              case 't':
                $s .= '\t';
                break;
                          
              case 'u':
                $u = 0;
                              
                for ($i = 0; $i < 4; $i += 1) {
                  $t = (integer) sprintf('%01c', hexdec($this->next()));
                                  
                  if (!is_numeric($t)) {
                    break 2;
                  }
                  $u = $u * 16 + $t;
                }
                              
                $s .= chr($u);
                break;
                          
              default:
                $s .= $this->ch;
            }
          } else {
            $s .= $this->ch;
          }
        }
      }
      
      $this->error('Bad string');
    }


    function arr() {
      $a = array();

      if ($this->ch == '[') {
        $this->next();
        $this->white();
                
        if ($this->ch == ']') {
          $this->next();
          return $a;
        }
                
        while ($this->ch) {
          array_push($a, $this->val());
          $this->white();
                    
          if ($this->ch == ']') {
            $this->next();
            return $a;
                    
          } elseif ($this->ch != ',') {
            break;
          }
                    
          $this->next();
          $this->white();
        }
            
        $this->error('Bad array');
      }
    }
 
    function obj() {
      $k = '';
      $o = new stdClass();

      if ($this->ch == '{') {
        $this->next();
        $this->white();
                
        if ($this->ch == '}') {
          $this->next();
          return $o;
        }
                
        while ($this->ch) {
          $k = $this->str();
          $this->white();
                    
          if ($this->ch != ':') {
            break;
          }
                    
          $this->next();
          $o->$k = $this->val();
          $this->white();
                    
          if ($this->ch == '}') {
            $this->next();
            return $o;
                    
          } elseif ($this->ch != ',') {
            break;
          }
                    
          $this->next();
          $this->white();
        }
      }
      
      $this->error('Bad object');
    }

   
    function assoc() {
      $k = '';
      $a = array();

      if ($this->ch == '<') {
        $this->next();
        $this->white();
                
        if ($this->ch == '>') {
          $this->next();
          return $a;
        }
                
        while ($this->ch) {
          $k = $this->str();
          $this->white();
                    
          if ($this->ch != ':') {
            break;
          }
                    
          $this->next();
          $a[$k] = $this->val();
          $this->white();
                    
          if ($this->ch == '>') {
            $this->next();
            return $a;
                    
          } elseif ($this->ch != ',') {
            break;
          }
                    
          $this->next();
          $this->white();
        }
      }
      
      $this->error('Bad associative array');
    }

    function num() {
      $n = '';
      $v = '';
            
      if ($this->ch == '-') {
        $n = '-';
        $this->next();
      }
            
      while ($this->ch >= '0' 
        && $this->ch <= '9') {
        
        $n .= $this->ch;
        $this->next();
      }
            
      if ($this->ch == '.') {
        $n .= '.';
                
        while ($this->next() 
          && $this->ch >= '0' 
          && $this->ch <= '9') {
          
            $n .= $this->ch;
          }
        }
            
      if ($this->ch == 'e' 
        || $this->ch == 'E') {
                
        $n .= 'e';
        $this->next();
                
        if ($this->ch == '-' 
          || $this->ch == '+') {
          
          $n .= $this->ch;
          $this->next();
        }

        while ($this->ch >= '0' 
          && $this->ch <= '9') {

          $n .= $this->ch;
          $this->next();
        }
      }
            
      $v += $n;
      
      if (!is_numeric($v)) {
        $this->error('Bad number');
      
      } else {
        return $v;
      } // end: if
    }

   
    function word() {
      switch ($this->ch) {
              
        case 't':
                    
          if ($this->next() == 'r' 
            && $this->next() == 'u' 
            && $this->next() == 'e') {
                        
            $this->next();
            return true;
          }
          break;
                
        case 'f':
          if ($this->next() == 'a' 
            && $this->next() == 'l' 
            && $this->next() == 's' 
            && $this->next() == 'e') {
                        
            $this->next();
            return false;
          }
          break;
                
        case 'n':
          if ($this->next() == 'u' 
            && $this->next() == 'l' 
            && $this->next() == 'l') {
                        
            $this->next();
            return null;
          }
          break;
      }
            
      $this->error('Syntax error');
    }

  
    function val() {
      $this->white();
            
      switch ($this->ch) {
                
        case '{':
          return $this->obj();
                
        case '[':
          return $this->arr();
                
        case '<':
          return $this->assoc();
                
        case '"':
          return $this->str();
                
        case '-':
          return $this->num();
                
        default:
          return ($this->ch >= '0' && $this->ch <= '9') ? $this->num() : $this->word();
      }
    }
  }
  
?>