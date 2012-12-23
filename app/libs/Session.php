<?php

/**
 * This class encapsulates PHP session, and it's used for abstracting from this.
 * 
 * @author Michele Stolfa
 * @version 1.0
 */
class Session {
	
	/**
	 * Initialize a new session.
	 */
	public static function init() {
		 $is_started = @session_start();
	}
	
	/**
	 * Set a new (key, value) couple in the current session.
	 * 
	 * @param string $key The new key
	 * @param mixed $value The new value
	 */
	public static function set($key, $value) {
		$_SESSION[$key] = $value;
	}
	
	/**
	 * Get the value corresponding to the given key.
	 * 
	 * @param string $key The given key
	 * @return mixed|boolean The value associated with $key, or false if $key isn't set in the current session.
	 */
	public static function get($key) {
		if (isset($_SESSION[$key]))
			return $_SESSION[$key];
		
		return false;
	}
	
	/**
	 * Destroy the current session.
	 */
	public static function destroy() {
		session_start();
		session_destroy();
	}
	
}