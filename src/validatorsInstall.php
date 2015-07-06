<?php
require_once __DIR__."/../../../autoload.php";
use Mouf\Actions\InstallUtils;
use Mouf\MoufManager;

// Let's init Mouf
InstallUtils::init(InstallUtils::$INIT_APP);

// Let's create the instance
$moufManager = MoufManager::getMoufManager();
if (!$moufManager->instanceExists("validatorsTranslateService")) {
    $validatorsTranslateService = InstallUtils::getOrCreateInstance('validatorsTranslateService', "Mouf\\Utils\\I18n\Fine\\Translator\\FileTranslator", $moufManager);
    $validatorsTranslateService->getConstructorArgumentProperty("i18nMessagePath")->setValue("vendor/mouf/utils.common.validators/src/resources/");

    if ($moufManager->instanceExists("defaultTranslationService")) {
        $defaultTranslationService = $moufManager->getInstanceDescriptor("defaultTranslationService");
        $values = $defaultTranslationService->getConstructorArgumentProperty('translators')->getValue();
        $values[] = $moufManager->getInstanceDescriptor("validatorsTranslateService");
        $defaultTranslationService->getConstructorArgumentProperty('translators')->setValue($values);
    }

    $validatorsBrowserLanguageDetection = InstallUtils::getOrCreateInstance('validatorsBrowserLanguageDetection', "Mouf\\Utils\\I18n\\Fine\\Language\\BrowserLanguageDetection", $moufManager);

    $validatorsTranslateService->getConstructorArgumentProperty("languageDetection")->setValue($validatorsBrowserLanguageDetection);
}

//Let's automatically create validators for the components that are not parametized (eg : don't create a MinMaxRangeValidator)...
$classes = array(
		"Mouf\\Utils\\Common\\Validators\\EmailValidator",
		'Mouf\\Utils\\Common\\Validators\\NumericValidator{"allowDecimals":true}',
		"Mouf\\Utils\\Common\\Validators\\RequiredValidator",
		'Mouf\\Utils\\Common\\Validators\\URLValidator{"allowFtp":true, "allowHttps":true}'
);

InstallUtils::massCreate($classes, $moufManager);

// Let's rewrite the MoufComponents.php file to save the component
$moufManager->rewriteMouf();

// Finally, let's continue the install
InstallUtils::continueInstall();
?>
