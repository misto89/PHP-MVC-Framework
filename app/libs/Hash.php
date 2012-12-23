<?php

/**
 * This class is used for encrypt some data.
 * 
 * @author Michele Stolfa
 * @version 1.0
 */
class Hash {
	
	/**
	 * Create hash for the given data.
	 *
	 * @param string $algo The algorithm (md5, sha1, whirlpool, etc)
	 * @param string $data The data to encode
	 * @return string The hashed/salted data
	 */
	public static function create($algo, $data) {
		
		$context = hash_init($algo, HASH_HMAC, HASH_PASSWORD_KEY);
		hash_update($context, $data);
		
		return hash_final($context);
		
	}
	
}