<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Telerivet HTTP Post Controller
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com>, Jesse Young <youngj@telerivet.com>
 * @package	   Ushahidi - http://source.ushahididev.com
 * @module	   Telerivet Controller	
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license	   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
*/

class Telerivet_Controller extends Controller {
	
	private $request = array();
	
	public function __construct()
    {
        $this->request = ($_SERVER['REQUEST_METHOD'] == 'POST')
            ? $_POST
            : $_GET;
    }
	
	/**
     * Telerivet 2 way callback handler
     * @return void
     */
	function webhook()
	{
        $message_from = (isset($this->request['from_number'])) ? $this->request['from_number'] : null;	
        $message_to = (isset($this->request['to_number'])) ? $this->request['to_number'] : null;		
        $message_description =(isset($this->request['content'])) ? $this->request['content'] : null;		
        $webhook_secret = isset($this->request['secret']) ? $this->request['secret'] : null;

		if ( ! empty($message_from) && ! empty($message_description) && $webhook_secret)
		{
			// Is this a valid Telerivet Webhook Secret?
			$keycheck = ORM::factory('telerivet')
				->where('webhook_secret', $webhook_secret)
				->find(1);

			if ($keycheck->loaded == TRUE)
			{
                sms::add($message_from, $message_description, $message_to);
			}
		}
	}
}
