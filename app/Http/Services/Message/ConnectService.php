<?php
 
 
namespace App\Http\Services\Message;

use Exception;

class ConnectService 
{
    public $debug;
    public $port;
    public $baud;
    protected $fp;
    protected $buffer;
    public $strReply = "";

    public function setDebug($debug){

        $this->debug= $debug ;

    }
    public function setPort($port){

        $this->port= $port ;

    }
    public function setBaud($baud){

        $this->baud= $baud ;

    }
    

    //Setup COM port
    public function init() {

        // $this->debugmsg("Setting up port: \"{$this->port} @ \"{$this->baud}\" baud");

        exec("MODE {$this->port}: BAUD={$this->baud} PARITY=N DATA=8 STOP=1", $output, $retval);

        if ($retval != 0) {
            throw new Exception('Unable to setup COM port, check it is correct');
        }

        $this->debugmsg(implode("\n", $output));

        $this->debugmsg("Opening port");

        //Open COM port
        $this->fp = fopen($this->port . ':', 'r+');

        //Check port opened
        if (!$this->fp) {
            throw new Exception("Unable to open port \"{$this->port}\"");
        }

        $this->debugmsg("Port opened");
        $this->debugmsg("Checking for responce from modem");

        //Check modem connected
        fputs($this->fp, "AT\r");

        //Wait for ok
        $status = $this->wait_reply("OK\r\n", 5);

        if (!$status) {
            throw new Exception('Did not receive responce from modem');
        }

        $this->debugmsg('Modem connected');

        //Set modem to SMS text mode
        $this->debugmsg('Setting text mode');
        fputs($this->fp, "AT+CMGF=1\r");

        $status = $this->wait_reply("OK\r\n", 5);

        if (!$status) {
            throw new Exception('Unable to set text mode');
        }

        $this->debugmsg('Text mode set');

    }

    //Wait for reply from modem
    protected function wait_reply($expected_result, $timeout) {
        // clear reply cache
		$this->strReply = "";

        $this->debugmsg("Waiting {$timeout} seconds for expected result");

        //Clear buffer
        $this->buffer = '';

        //Set timeout
        $timeoutat = time() + $timeout;

        //Loop until timeout reached (or expected result found)
        do {

            // $this->debugmsg('Now: ' . time() . ", Timeout at: {$timeoutat}");

            $buffer = fread($this->fp, 1024);
            $this->buffer .= $buffer;

            usleep(200000);//0.2 sec
            // $this->debugmsg("Received: {$buffer}");

                $strReply = "";
            // get response
		
			$strReply 		 = $buffer;
			$this->strReply	.= $strReply;
		

            //Check if received expected responce
            if (preg_match('/'.preg_quote($expected_result, '/').'$/', $this->buffer)) {
                $this->debugmsg('Found match');
                return true;
                //break;
            } else if (preg_match('/\+CMS ERROR\:\ \d{1,3}\r\n$/', $this->buffer)) {
                return false;
            }

        } while ($timeoutat > time());

        // $this->debugmsg('Timed out');

        return false;

    }

    //Print debug messages
    protected function debugmsg($message) {

        if ($this->debug == true) {
            $message = preg_replace("%[^\040-\176\n\t]%", '', $message);
            echo $message . "\n";
        }

    }

    //Close port
    public function close() {

        $this->debugmsg('Closing port');

        fclose($this->fp);

    }


   
   

}