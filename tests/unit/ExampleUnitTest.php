<?php
/**
 * Replace Variable plugin for Craft CMS 3.x
 *
 * Replace general or config variables and global fields
 *
 * @link      https://vimia.co.uk
 * @copyright Copyright (c) 2020 Nathan Reed
 */

namespace zizther\replacevariabletests\unit;

use Codeception\Test\Unit;
use UnitTester;
use Craft;
use zizther\replacevariable\ReplaceVariable;

/**
 * ExampleUnitTest
 *
 *
 * @author    Nathan Reed
 * @package   ReplaceVariable
 * @since     1.0.0
 */
class ExampleUnitTest extends Unit
{
    // Properties
    // =========================================================================

    /**
     * @var UnitTester
     */
    protected $tester;

    // Public methods
    // =========================================================================

    // Tests
    // =========================================================================

    /**
     *
     */
    public function testPluginInstance()
    {
        $this->assertInstanceOf(
            ReplaceVariable::class,
            ReplaceVariable::$plugin
        );
    }

    /**
     *
     */
    public function testCraftEdition()
    {
        Craft::$app->setEdition(Craft::Pro);

        $this->assertSame(
            Craft::Pro,
            Craft::$app->getEdition()
        );
    }
}
