<?php
/**
 * Replace Variable plugin for Craft CMS 3.x
 *
 * Replace general or config variables, and global fields
 *
 * @link      https://vimia.co.uk
 * @copyright Copyright (c) 2020 Nathan Reed
 */

namespace zizther\replacevariable\services;

use zizther\replacevariable\ReplaceVariable;

use Craft;
use craft\base\Component;
use craft\helpers\Template;

/**
 * ReplaceVariableService Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Nathan Reed
 * @package   ReplaceVariable
 * @since     1.0.0
 */
class ReplaceVariableService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * Replace Variables
     *
     * ReplaceVariable::$plugin->replaceVariableService->replaceVariables()
     *
     * Can match general or config variables and global fields
     * E.G.
     * {siteName}
     * {config.general.custom.variableName}
     * {config.customConfigFile.variableName}
     * {globalHandle.fieldHandle}
     *
     * @param [string] $string [The string to test against]
     * @return [string] [The replaced variable value]
     */
    public function replaceVariable($string)
    {
        // Regex to get keys within `{}`
        $regex = '/( { ( (?: [^{}]* | (?1) )* ) } )/x';

        $keys = [];
        $replace = [];

        // Put all matches into the $matches array
        preg_match_all($regex, $string, $keys);

        foreach ($keys[0] as $value) {
            $var = substr($value, 1, -1);
            $var = explode('.', $var);

            if ($var[0] == 'siteName') {
                array_push($replace, Craft::$app->sites->currentSite->name);
            }
            else {
                $configVar = $var[0] == 'config';
                $var1 = $var[1] ?? null;
                $isGlobal = !$configVar && $var1;

                if ($isGlobal) {
                    array_push($replace, $this->parseGlobal($var[0], $var[1]));
                }
                else {
                    if ($configVar) {
                        // Custom general config var
                        if ($var[1] == 'general' && $var[2] == 'custom'){
                            $cleanedVar = str_replace('"', '', $var[3]); // Remove quotes from array item
                            array_push($replace, Craft::$app->config->general->custom->$cleanedVar);
                        }
                        else {
                            $cleanedVar1 = str_replace('"', '', $var[1]); // Remove quotes from array item
                            $cleanedVar2 = str_replace('"', '', $var[2]); // Remove quotes from array item
                            array_push($replace, Craft::$app->config->getConfigFromFile($cleanedVar1)[$cleanedVar2]);
                        }
                    }
                    else {
                        $cleanedVar = str_replace('"', '', $var[0]); // Remove quotes from array item
                        array_push($replace, Craft::$app->config->general->$cleanedVar);
                    }
                }
            }
        }

        return Template::raw(str_replace($keys[0], $replace, $string));
    }// END replaceVariables


    /**
     * Parse globals
     * Get the value of a global field based on its set
     *
     * @param [string] $set [The global set]
     * @param [string] $field [The global field]
     * @return [string] [The global field value]
     */
    public function parseGlobal($set, $field)
    {
        $value = Craft::$app->getGlobals()->getSetByHandle($set)[$field];

        return $value;
    }// END parseGlobal
}
