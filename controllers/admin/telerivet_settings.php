<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Telerivet Settings Controller
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com>, Jesse Young <youngj@telerivet.com>
 * @package    Ushahidi - http://source.ushahididev.com
 * @module	   Telerivet Settings Controller	
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
* 
*/

class Telerivet_Settings_Controller extends Admin_Controller {
	public function index()
	{
		$this->template->this_page = 'addons';
		
		// Standard Settings View
		$this->template->content = new View("admin/addons/plugin_settings");
		$this->template->content->title = "Telerivet Settings";
		
		// Settings Form View
		$this->template->content->settings_form = new View("telerivet/admin/telerivet_settings");
		
		// JS Header Stuff
        //$this->template->js = new View('telerivet/admin/telerivet_settings_js');
		
		// setup and initialize form field names
        $form = array
        (
            'webhook_secret' => '',
            'api_key' => '',
            'project_id' => '',
        );
        //  Copy the form as errors, so the errors will be stored with keys
        //  corresponding to the form field names
        $errors = $form;
        $form_error = FALSE;
        $form_saved = FALSE;

        // check, has the form been submitted, if so, setup validation
        if ($_POST)
        {
            // Instantiate Validation, use $post, so we don't overwrite $_POST
            // fields with our own things
            $post = new Validation($_POST);

            // Add some filters
            $post->pre_filter('trim', TRUE);

            // Add some rules, the input field, followed by a list of checks, carried out in order

            $post->add_rules('api_key', 'required', 'length[20,50]');
            $post->add_rules('project_id', 'required', 'length[20,50]');

            // Test to see if things passed the rule checks
            if ($post->validate())
            {
                // Yes! everything is valid
                $telerivet = new Telerivet_Model(1);
                $telerivet->webhook_secret = trim($post->webhook_secret);
                $telerivet->api_key = trim($post->api_key);
                $telerivet->project_id = trim($post->project_id);
                $telerivet->save();

                // Everything is A-Okay!
                $form_saved = TRUE;

                // repopulate the form fields
                $form = arr::overwrite($form, $post->as_array());

            }

            // No! We have validation errors, we need to show the form again,
            // with the errors
            else
            {
                // repopulate the form fields
                $form = arr::overwrite($form, $post->as_array());

                // populate the error fields, if any
                $errors = arr::overwrite($errors, $post->errors('settings'));
                $form_error = TRUE;
            }
        }
        else
        {
            // Retrieve Current Settings
            $telerivet = ORM::factory('telerivet', 1);

            $form = array
            (
                'api_key' => $telerivet->api_key,
                'webhook_secret' => $telerivet->webhook_secret,
                'project_id' => $telerivet->project_id
            );
        }
		
		// Pass the $form on to the settings_form variable in the view
		$this->template->content->settings_form->form = $form;
        $this->template->content->settings_form->webhook_url = url::site()."telerivet/webhook";
		
		// Other variables
	    $this->template->content->errors = $errors;
		$this->template->content->form_error = $form_error;
		$this->template->content->form_saved = $form_saved;
	}	
}