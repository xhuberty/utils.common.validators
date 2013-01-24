<?php

namespace Mouf\Utils\Common\Validators;

/**
 * Siret validator
 * 
 * @Component
 */
class SiretValidator extends AbstractValidator implements JsValidatorInterface {

    /**
     * (non-PHPdoc)
     * @see ValidatorInterface::validate()
     */
    function doValidate($value) {
        $siret = str_replace(' ', '', $value);
        if (strlen($siret) != 14 || !is_numeric($siret)) {
            return false;
        }

        $siren = substr($siret, 0, 9);

        //SIREN validation  - IF SIREN = NOK => SIRET = NOK
        $total_siren = 0;
        for ($i = 0; $i < 9; $i++) {
            $temp_siren = substr($siren, $i, 1);
            if ($i % 2 == 1) {
                $temp_siren *= 2;
                if ($temp_siren > 9) {
                    $temp_siren -= 9;
                }
            }
            $total_siren += $temp_siren;
        }
        if (($total_siren % 10) != 0)
            return false;




        $total = 0;
        for ($i = 0; $i < 14; $i++) {
            $temp = substr($siret, $i, 1);
            if ($i % 2 == 0) {
                $temp *= 2;
                if ($temp > 9) {
                    $temp -= 9;
                }
            }
            $total += $temp;
        }
        return (($total % 10) == 0);
    }

    /**
     * (non-PHPdoc)
     * @see JsValidatorInterface::getScript()
     */
    function getScript() {
        return "function(value, element){
                        var siret = value;
			var estvalide;
                        if ( (siret.length != 14) || (isnan(siret)))
                            estvalide = false;
                        else {
                            //~ donc le siret est un numérique à 14 chiffres
                            //~ les 9 premiers chiffres sont ceux du siren (ou rcs), les 4 suivants
                            //~ correspondent au numéro d'établissement
                            //~ et enfin le dernier chiffre est une clef de luhn. 
                            
                            var somme = 0;
                            var tmp;
                            for (var cpt = 0; cpt<siret.length; cpt++) {
                                if ((cpt % 2) == 0) { //~ les positions impaires : 1er, 3è, 5è, etc... 
                                    tmp = siret.charat(cpt) * 2; //~ on le multiplie par 2
                                    if (tmp > 9) 
                                    tmp -= 9;	//~ si le résultat est supérieur à 9, on lui soustrait 9
                                }
                                else
                                    tmp = siret.charat(cpt);
                                    
                                somme += parseint(tmp);
                            }
                            
                            if ((somme % 10) == 0)
                                estvalide = true; //~ si la somme est un multiple de 10 alors le siret est valide 
                            else
                                estvalide = false;
                        }
                        return estvalide;
	}";
    }

    /**
     * (non-PHPdoc)
     * @see JsValidatorInterface::getErrorMessage()
     */
    function getErrorMessage() {
        return ValidatorUtils::translate("validate.siret");
    }

    /**
     * (non-PHPdoc)
     * @see JsValidatorInterface::getJsArguments()
     */
    function getJsArguments() {
        return true;
    }

}

?>