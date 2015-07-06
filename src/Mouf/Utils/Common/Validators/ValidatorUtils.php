<?php 
namespace Mouf\Utils\Common\Validators;

use Mouf\MoufManager;

/**
 * Class providing utility methods (especially regarding translation) to the validators.
 * 
 * @author David Negrier
 */
class ValidatorUtils {
	
	/**
	 * 
	 * @param string $msg
	 */
	public static function translate($msg, array $params = array()) {
		$translationService = MoufManager::getMoufManager()->getInstance("defaultTranslationService");

        return $translationService->getTranslation($msg, $params);
	}
}
?>