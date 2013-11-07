<?php
namespace Mouf\Utils\Common\Validators;
/**
 * Basic validator that defines a value as required
 * 
 * @Component
 */
class FileUploaderRequiredValidator extends AbstractValidator implements JsValidatorInterface{
	
	/**
	 * (non-PHPdoc)
	 * @see PhpValidatorInterface::validate()
	 */
	function doValidate($value){
		return !empty($value) || $value == "0" || $value == 0;
	}

	/**
	 * (non-PHPdoc)
	 * @see JsValidatorInterface::getScript()
	 */
	function getScript(){
		return "
			function (value, element){
				if(_getLength(value, element) > 0) {
					return true;
				}
				else {
					var hasElement = $(element)[0].id+'__fileuploader_hasfile';
					if($('.has-fileupload-'+element.id).length > 0) {
						return true;
					}
				}
				return false;
			}
		";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see JsValidatorInterface::getErrorMessage()
	 */
	function getErrorMessage(){
		return ValidatorUtils::translate("validate.required");
	}
	
	/**
	 * (non-PHPdoc)
	 * @see JsValidatorInterface::getJsArguments()
	 */
	function getJsArguments(){
		return true;
	}
}
?>