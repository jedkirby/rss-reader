<?php namespace App\Core;

use App\Core\Config;
use App\Core\Feeder;
use \Exception;

class Validation {

	/**
	 * Field to be validated.
	 * 
	 * @var array
	 */
	protected $fields = [];

	/**
	 * Validation errors.
	 * 
	 * @var array
	 */
	protected $errors = [];

	/**
	 * Validation messages.
	 * 
	 * @var array
	 */
	protected $messages;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		Config::load('validation');
		$this->messages = Config::get('validation', 'messages');
	}

	/**
	 * Add a field to the validator.
	 * 
	 * @param string $field
	 * @param array  $rules
	 * @param mixed  $value
	 */
	public function add($field, $rules = [], $value = '')
	{
		$this->fields[$field] = compact('rules', 'value');
	}

	/**
	 * Cycle through all the fields and run each of the rules applied.
	 *
	 * @throws Exception
	 * @return boolean
	 */
	public function run()
	{
		foreach($this->fields as $name => $field){
			foreach($field['rules'] as $rule){
				$method = 'validate'.ucwords($rule);
				if( !method_exists($this, $method) ){
					throw new Exception('Unable to locate the "'.$rule.'" validation method.');
				}
				$this->$method($name, $field['value']);
			}
		}
		return (bool) empty($this->errors);
	}

	/**
	 * Fetch all errors.
	 * 
	 * @return array
	 */
	public function errors()
	{
		return $this->errors;
	}

	/**
	 * Required validation.
	 * 
	 * @param  string $field
	 * @param  mixed  $value
	 * @return void
	 */
	protected function validateRequired($field, $value)
	{
		if( empty($value) ){
			$this->addError($field, 'required');
		}
	}

	/**
	 * URL validation.
	 * 
	 * @param  string $field
	 * @param  mixed  $value
	 * @return void
	 */
	protected function validateUrl($field, $value)
	{
		if( !filter_var($value, FILTER_VALIDATE_URL) ){
			$this->addError($field, 'url');
		}
	}

	/**
	 * XML validation.
	 * 
	 * @param  string $field
	 * @param  mixed  $value
	 * @return void
	 */
	protected function validateXml($field, $value)
	{
		try {
			$feeder = new Feeder($value);
			$feeder->fetchFeed(); // Slow, but.. 
		}
		catch( \Exception $e ){
			$this->addError($field, 'xml');
		}
	}

	/**
	 * Insert an error into the errors array.
	 * 
	 * @param string $field
	 * @param string $rule
	 */
	protected function addError($field, $rule)
	{
		if( !array_key_exists($field, $this->errors) ){
			$this->errors[$field] = [];
		}
		$this->errors[$field][] = str_replace(':name', $field, $this->messages[$rule]);
	}

}
