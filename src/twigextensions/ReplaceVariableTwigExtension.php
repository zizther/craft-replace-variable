<?php
/**
 * Replace Variable plugin for Craft CMS 3.x
 *
 * Replace general or config variables, and global fields
 *
 * @link      https://vimia.co.uk
 * @copyright Copyright (c) 2020 Nathan Reed
 */

namespace zizther\replacevariable\twigextensions;

use zizther\replacevariable\ReplaceVariable;
use zizther\replacevariable\services\ReplaceVariableService as ReplaceVariableServiceService;

use Craft;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Twig can be extended in many ways; you can add extra tags, filters, tests, operators,
 * global variables, and functions. You can even extend the parser itself with
 * node visitors.
 *
 * http://twig.sensiolabs.org/doc/advanced.html
 *
 * @author    Nathan Reed
 * @package   ReplaceVariable
 * @since     1.0.0
 */
class ReplaceVariableTwigExtension extends AbstractExtension
{
    // Public Methods
    // =========================================================================

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'ReplaceVariable';
    }

    /**
     * Returns an array of Twig filters, used in Twig templates via:
     *
     * {{ 'something goes here {globalHandle.fieldHandle}' | rv }}
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            new TwigFilter('rv', [$this, ReplaceVariable::$plugin->replaceVariableService, 'replaceVariable']),
        ];
    }

    /**
     * Returns an array of Twig functions, used in Twig templates via:
     *
     * {% set this = rv('something goes here {globalHandle.fieldHandle}') %}
     *
    * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('rv', [ReplaceVariable::$plugin->replaceVariableService, 'replaceVariable']),
        ];
    }
}
