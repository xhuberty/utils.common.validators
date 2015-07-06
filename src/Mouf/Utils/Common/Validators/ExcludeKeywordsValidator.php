<?php
namespace Mouf\Utils\Common\Validators;

use Mouf\Utils\Value\ValueUtils;

use Mouf\Utils\Value\ValueInterface;

/**
 * Validate words according to a banned-word list
 */
class ExcludeKeywordsValidator implements ValidatorInterface {

	/**
	 * Stream used to analyze
	 * @var string|array|ValueInterface
	 */
	public $excludes;
	
	/**
	 * 
	 * @var array
	 */
	protected $banned_words;
		
	/**
	 * @param mixed $value the value to validate
	 * @return true if the value validates, false if it doesn't.
	 */
	public function doValidate($value){
		$val_excludes = ValueUtils::val($this->excludes);
		if(is_array($val_excludes)){
			//Case the value interface return an array
			foreach ($val_excludes as $exclud){
				if(preg_match_all("/\b".$exclud."\b/i",$value)){
					$this->banned_words[] = $exclud;
				}
			}
				
		}else{
			//Case the value interface return a string
			$array_excludes = explode(',', $val_excludes);
			foreach ($array_excludes as $exclud){
				if(preg_match_all("/\b".$exclud."\b/i",$value)){
					$this->banned_words[] = $exclud;
				}
			}
		}

		if(!empty($this->banned_words)){
			return false;
		}else{
			return true;
		}
	}
	
	/**
	 * @return string
	 */
	public function getErrorMessage(){
		return ValidatorUtils::translate('validate.gross-keywords');
	}
	
	public function getBannedWords(){
		$html = '';
		foreach ($this->banned_words as $word){
			$html .= (strlen($html) == 0) ? $word : ', '.$word;
		}
		return $html;
	}
	
}

?>