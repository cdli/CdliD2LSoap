<?php

/**
 * Desire2Learn Web Serivces for Zend Framework
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @author Thomas Hawkins <thawkins@mun.ca>
 *
 * $Id: Client.php 18 2011-02-07 15:53:03Z adamlundrigan $
 *
 */

/**
 * SOAP Client
 */
class D2LWS_Soap_Client extends Zend_Soap_Client implements D2LWS_Soap_Client_Interface
{
    /**
     * D2LWS Instance
     * @type D2LWS_Instance
     */
    protected $_instance = NULL;
    
    /**
     * Default constructor for SOAP client
     * @param $wsdl string - WSDL file
     * @param $options array - Options
     */
    public function __construct($wsdl = NULL, $options = NULL)
    {
        parent::__construct($wsdl);
    }
    

    /**
     * Invoke method on remote server
     * @param string $method
     * @param array $args
     * @return mixed Result of remote call
     */
    public function __call($method, $args)
    {
        $i = $this->getInstance();
       
        /*
         * Check and see if $request first element is single entity (ns2:)
         * or an array or OrgUnitId or UserId (ns1:)
         */

        $NS = @( is_array($args[0]) && count($args[0]) > 0 && is_array($args[0][array_shift(array_keys($args[0]))]) ? 'ns1' : 'ns2' );
        $rawheaders = "<{$NS}:RequestHeader>";
        $rawheaders .= "<{$NS}:Version>1.0</{$NS}:Version><{$NS}:CorellationId>123456</{$NS}:CorellationId>";
        if ( !in_array(strtolower($method), array('authenticate','authenticate2')) )
        {
            $rawheaders .= "<{$NS}:AuthenticationToken>";
            $rawheaders .= $i->getAuthToken();
            $rawheaders .= "</{$NS}:AuthenticationToken>";
        }
        $rawheaders .= "</{$NS}:RequestHeader>";
        $innerHeader = new SoapVar($rawheaders,XSD_ANYXML);
        $metaheader = new SoapHeader($i->getConfig('webservice.common.namespace'),'RequestHeader',$innerHeader);//$headers);
        $this->addSoapInputHeader($metaheader);

        $result = parent::__call($method, $args);

        $xml = new SimpleXMLElement($this->getLastResponse());
        $header = @array_shift($xml->xpath('/soap:Envelope/soap:Header'));
        if ( $header != NULL && $header->ResponseHeader->Status->Code != 'Success') 
        {
            if ( isset($header->ResponseHeader->Status->SystemErrors->SystemErrorInfo->Message) )
            {
                throw new D2LWS_Soap_Client_Exception($header->ResponseHeader->Status->SystemErrors->SystemErrorInfo->Message);
            }
            elseif ( isset($header->ResponseHeader->Status->Code) )
            {
                $exbody = array_shift($xml->xpath('/soap:Envelope/soap:Body'));
                $opname = $header->ResponseHeader->OperationName;
                $respname = preg_replace("/Request$/", "Response", $opname);
                
                switch ( $header->ResponseHeader->Status->Code )
                {
                    case 'BusinessRuleFailure':
                    {
                        $extype = @$exbody->$respname->BusinessErrors->BusinessErrorInfo->ErrorType;
                        $exmessage = @$exbody->$respname->BusinessErrors->BusinessErrorInfo->Message;
                        break;
                    }
                    default:
                    {
                        $extype = "Unknown";
                        $exmessage = "Unknown Error Type Returned!";
                        break;
                    }
                }
                
                throw new D2LWS_Soap_Client_Exception("{$extype}: {$exmessage}");
                
            }
        }

        return $result;
    }
    
    public function doDebug()
    {
        echo "<br />\nDumping request headers:\n<br /><pre><code>" . htmlentities(str_replace(">",">\n",$this->getLastRequestHeaders())). "</code></pre>";
        echo "<br />\nDumping request:\n<br /><pre><code>" .  htmlentities($this->_formatXmlString($this->getLastRequest())) . "</code></pre>";
        echo "<br />\nDumping response headers:\n<br /><pre><code>" . htmlentities(str_replace(">",">\n",$this->getLastResponseHeaders())). "</code></pre>";
        echo "<br />\nDumping response:\n<br /><pre><code>" . htmlentities($this->_formatXmlString($this->getLastResponse())). "</code></pre>";	
    }
    
    protected function _formatXmlString($xml,$padstr = ' ') {  
      
        // add marker linefeeds to aid the pretty-tokeniser (adds a linefeed between all tag-end boundaries)
        $xml = preg_replace('/(>)(<)(\/*)/', "$1\n$2$3", $xml);
      
        // now indent the tags
        $token      = strtok($xml, "\n");
        $result     = ''; // holds formatted version as it is built
        $pad        = 0; // initial indent
        $matches    = array(); // returns from preg_matches()
      
        // scan each line and adjust indent based on opening/closing tags
        while ($token !== false) : 
      
            // test for the various tag states
        
            // 1. open and closing tags on same line - no change
            if (preg_match('/.+<\/\w[^>]*>$/', $token, $matches)) : 
                $indent=0;
            // 2. closing tag - outdent now
            elseif (preg_match('/^<\/\w/', $token, $matches)) :
                $pad--;
            // 3. opening tag - don't pad this one, only subsequent tags
            elseif (preg_match('/^<\w[^>]*[^\/]>.*$/', $token, $matches)) :
                $indent=1;
            // 4. no indentation needed
            else :
                $indent = 0; 
            endif;
        
            // pad the line with the required number of leading spaces
            $line    = str_pad($token, strlen($token)+$pad, $padstr, STR_PAD_LEFT);
            $result .= $line . "\n"; // add to the cumulative result, with linefeed
            $token   = strtok("\n"); // get the next token
            $pad    += $indent; // update the pad size for subsequent lines    
        endwhile; 

        return $result;
    }
    
    /**
     * Set D2LWS instance
     * @param $inst Instance to assign
     * @return $this
     */
    public function setInstance(D2LWS_Instance $inst)
    {
        $this->_instance = $inst;
        return $this;
    }
    
    /**
     * Get D2LWS instance
     * @return D2LWS instance
     */
    public function getInstance() { return $this->_instance; }

}