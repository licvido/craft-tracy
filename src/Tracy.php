<?php
/**
 * Tracy plugin for Craft CMS 3.x
 *
 * A must-have debugging tool for all PHP developers
 *
 * @link      https://www.github.com/siteone/craft-tracy
 * @copyright Copyright (c) 2021 SiteOne, s.r.o.
 */

namespace siteone\tracy;

use Craft;
use craft\base\Plugin;
use Idmarinas\TracyPanel\TwigBar;
use siteone\tracy\twigextensions\TracyTwigExtension;
use Tracy\Debugger;
use Twig\Extension\ProfilerExtension;
use Twig\Profiler\Profile;

/**
 * Tracy plugin
 *
 * @author    SiteOne, s.r.o.
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
