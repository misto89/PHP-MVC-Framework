<?php

/**
 * This class is used to translate all application strings and texts.
 * 
 * @author Michele Stolfa
 * @version 1.0
 */
class Translator {
	
	/**
	 * An associative array contains all strings.
	 * 
	 * @var array Associative array in this format: array('id string' => 'translation string')
	 */
	private $dictionary;
	
	/**
	 * Loads dictionary for the given language.
	 * 
	 * @param string $local Local language by which translate strings. Default is english
	 */
	public function __construct($local = 'en_EN') {
		$file = LANG_PATH . $local . '.php';
		include $file;
		$this->dictionary = $dictionary;
	}
		
	/**
	 * Translate a single string or text.
	 * 
	 * @param string/integer $id_string String identificator
	 */
	public function translate($id_string) {
		return $this->dictionary[$id_string];
	}
}