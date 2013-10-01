<?php

/**
 * This class wraps memcache and amkes it more accessable to the remainder of the application
 *
 */
class CacheManager {
	private static $instance = null;
	
	public static function getInstance() {
		if(self::$instance == null) {
			self::$instance = new CacheManager();	
		}
		
		return self::$instance;
	}
	
	private $memcache;
	private function __construct() {
		$this->memcache = new Memcache();
		$this->memcache->connect('localhost', 11211) or die("Couldn't connect to memcache.");
	}
	
	/**
	 * Set a value in the cache.
	 * @param string $key
	 * @param string $value
	 * @param number $exp Set to 0 for no expiry (default). Alternatively use a number of seconds OR a unix timestamp.
	 */
	public function set($key, $value, $exp = 0) {
		$this->memcache->set($key, $value, FALSE, $exp);
	}
	
	/**
	 * Read a value from the cache
	 * @param string $key
	 * @return string Returns the value or false if the key is not in the database.
	 */
	public function get($key) {
		return $this->memcache->get($key);
	}
	
	public function delete($key) {
		$this->memcache->delete($key);
	}
}