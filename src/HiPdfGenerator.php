<?php
/**
 * HI PDF Generator plugin for Craft CMS 3.x
 *
 * Generates PDFs from templates with the typeset.sh library
 *
 * @link      https://bitbucket.org/hi-schweiz/
 * @copyright Copyright (c) 2022 HI Digital
 */

namespace hi_digital\hipdfgenerator;


use hi_digital\hipdfgenerator\variables\HiPdfGeneratorVariable;
use hi_digital\hipdfgenerator\models\Settings;
use hi_digital\hipdfgenerator\base\PluginTrait;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\twig\variables\CraftVariable;

use yii\base\Event;

/**
 * Class HiPdfGenerator
 *
 * @author    HI Digital
 * @package   HiPdfGenerator
 * @since     0.0.1
 *
 */
class HiPdfGenerator extends Plugin
{
    // Static Properties
    // =========================================================================
    use PluginTrait;

    /**
     * @var HiPdfGenerator
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var bool
     */
    public $hasCpSettings = true;

    /**
     * @var bool
     */
    public $hasCpSection = false;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;
        $this->_setPluginComponents();

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('hiPdf', HiPdfGeneratorVariable::class);
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'hi-pdf-generator',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'hi-pdf-generator/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
