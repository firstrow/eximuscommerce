<?php
/**
 * Validate local urls.
 * 
 * @package validators
 */
class LocalUrlValidator extends CUrlValidator
{
//	public $pattern='/^(([A-Z0-9][A-Z0-9_-]*))/i';
	public $pattern='/^[a-z0-9-]+$/';
}