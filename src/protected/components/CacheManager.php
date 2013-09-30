<?php
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
	
	public function set($key, $value, $exp = 0) {
		$this->memcache->set($key, $value, FALSE, $exp);
	}
	
	public function get($key) {
		return $this->memcache->get($key);
	}
}