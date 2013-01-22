<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Performs install/uninstall methods for the Telerivet Plugin
 *
 * @package    Ushahidi
 * @author     Ushahidi Team, Jesse Young <youngj@telerivet.com>
 * @copyright  (c) 2008 Ushahidi Team
 * @license    http://www.ushahidi.com/license.html
 */
class Telerivet_Install {
	
	/**
	 * Constructor to load the shared database library
	 */
	public function __construct()
	{
		$this->db =  new Database();
	}

	/**
	 * Creates the required columns for the Telerivet Plugin
	 */
	public function run_install()
	{
		
		// ****************************************
		// DATABASE STUFF
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `".Kohana::config('database.default.table_prefix')."telerivet`
			(
				id int(11) unsigned NOT NULL AUTO_INCREMENT,
				webhook_secret varchar(100) DEFAULT NULL,
				api_key varchar(100) DEFAULT NULL,
				project_id varchar(100) DEFAULT NULL,
				PRIMARY KEY (`id`)
			);
		");
		// ****************************************
	}

	/**
	 * Drops the Telerivet Tables
	 */
	public function uninstall()
	{
		$this->db->query("
			DROP TABLE ".Kohana::config('database.default.table_prefix')."telerivet;
			");
	}
}