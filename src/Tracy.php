<?php
/**
 * Tracy plugin for Craft CMS 3.x
 *
 * A must-have debugging tool for all PHP developers
 *
 * @link      https://www.github.com/licvido/craft-tracy
 * @copyright Copyright (c) 2021 Filip Mikovcak
 */

namespace licvido\tracy;

use Craft;
use craft\base\Plugin;
use Idmarinas\TracyPanel\TwigBar;
use licvido\tracy\twigextensions\TracyTwigExtension;
use Tracy\Debugger;
use Twig\Extension\ProfilerExtension;
use Twig\Profiler\Profile;

/**
 * Tracy plugin
 *
 * @author    Filip Mikovcak
 * @package   Tracy
 * @since     1.0.0
 *
 */
class Tracy extends Plugin
{

    /**
     * @var Tracy
     */
    public static $plugin;

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public $hasCpSettings = false;

    /**
     * @var bool
     */
    public $hasCpSection = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        $isDebug = Craft::$app->view->twig->isDebug();
        $profile = new Profile();

        Craft::$app->view->registerTwigExtension(new TracyTwigExtension());
        Craft::$app->view->registerTwigExtension(new ProfilerExtension($profile));

        Debugger::$showLocation = false;
        Debugger::enable($isDebug ? Debugger::DEVELOPMENT : Debugger::PRODUCTION);
        TwigBar::init($profile);

        Craft::info(
            Craft::t(
                'tracy',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

}
