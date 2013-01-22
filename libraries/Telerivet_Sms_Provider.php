<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Helper library for the Telerivet API
 *
 * @package     Telerivet SMS 
 * @category    Plugins
 * @author      Ushahidi Team, Jesse Young <youngj@telerivet.com>
 * @copyright   (c) 2008-2011 Ushahidi Team
 * @license     http://www.gnu.org/copyleft/lesser.html GNU Less Public General License (LGPL)
 */
class Telerivet_Sms_Provider implements Sms_Provider_Core {
	
    static $api_domain = "https://api.telerivet.com";
    
	/**
	 * Sends a text message (SMS) using the Telerivet API
	 *
	 * @param string $to
	 * @param string $from
	 * @param string $to
	 */
	public function send($to = NULL, $from = NULL, $message = NULL)
	{
		// Get Current Telerivet Settings
		$telerivet = ORM::factory("telerivet", 1)->find();
		
		if ($telerivet->loaded)
		{
            $api_key = $telerivet->api_key;
            $project_id = $telerivet->project_id;
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 
                self::$api_domain . "/v1/projects/$project_id/messages/outgoing");
            curl_setopt($curl, CURLOPT_USERPWD, "{$api_key}:");  
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array(
                'content' => $message,
                'from_number' => $from,
                'to_number' => $to,
            )));
    
            curl_setopt($curl, CURLOPT_CAINFO, dirname(dirname(__FILE__)) . "/cacert.pem");    
    
            $json = curl_exec($curl);            
            $network_error = curl_error($curl);            
            curl_close($curl);                
            
            if ($network_error) 
            { 
                return $network_error;
            }
                        
            $res = json_decode($json, true);        
            if (isset($res['error']))
            {
                return $res['error']['message'];
            }
            else if (!$res)
            {
                return "Unknown error accessing Telerivet API";
            }            
            
            return true;
		}
		
		return "Telerivet Is Not Set Up!";
	}
	
}