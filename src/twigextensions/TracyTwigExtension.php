<?php
/**
 * Tracy plugin for Craft CMS 3.x
 *
 * A must-have debugging tool for all PHP developers
 *
 * @link      https://www.github.com/licvido/craft-tracy
 * @copyright Copyright (c) 2021 Filip Mikovcak
 */

namespace licvido\tracy\twigextensions;

use Tracy\Debugger;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * @author    Filip Mikovcak
 * @package   Tracy
 * @since     1.0.0
 */
class TracyTwigExtension extends AbstractExtension
{

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Tracy';
    }

    /**
     * @inheritdoc
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('dump', [$this, 'dump']),
            new TwigFunction('dumpe', [$this, 'dumpe']),
            new TwigFunction('bdump', [$this, 'bdump']),
        ];
    }

    /**
     * Tracy\Debugger::dump()
     * @tracySkipLocation
     */
    function dump()
    {
        array_map([Debugger::class, 'dump'], func_get_args());
    }

    /**
     * Tracy\Debugger::dump() & exit
     * @tracySkipLocation
     */
    function dumpe()
    {
        array_map([Debugger::class, 'dump'], func_get_args());
        if (!Debugger::$productionMode) {
            exit;
        }
    }

    /**
     * Tracy\Debugger::barDump()
     * @tracySkipLocation
     */
    function bdump()
    {
        Debugger::barDump(...func_get_args());
    }

}
