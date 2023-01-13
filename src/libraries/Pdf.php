<?php
/**
 * HI PDF Generator plugin for Craft CMS 4.x
 *
 * Generates PDFs from templates with the typeset.sh library
 *
 * @link      https://bitbucket.org/hi-schweiz/
 * @copyright Copyright (c) 2023 HI Digital
 */

namespace hi_digital\hipdfgenerator\libraries;

use Craft;
use hi_digital\hipdfgenerator\HiPdfGenerator as Generator;
use hi_digital\hipdfgenerator\models\Settings;
use yii\base\Exception;

// Require typeset.sh library
require_once __DIR__ . '/typesetsh.lib.phar';

class Pdf
{

    /**
     * @param $configuration
     * @return string
     * @throws \craft\errors\SiteNotFoundException
     */
    public function generatePdf($configuration = null): string
    {

        $settings = Generator::$plugin->getSettings();
        $currentSiteName = Craft::$app->getSites()->getCurrentSite()->name;

        $filename = $currentSiteName . uniqid() . '.pdf';
        $destination = 'inline';

        // Check settings and throw exception if not set
        if (!isset($settings['assetFolder']) || $settings['assetFolder'] === '') {
            throw new Exception('HI PDF Plugin - No default PDF save location provided in the control panel settings');
        }

        if (!isset($configuration['template'])) {
            throw new Exception('HI PDF Plugin - No template path provided');
        }


        if (isset($configuration['filename'])) {
            $filename = $configuration['filename'];
        } elseif (isset($configuration['title'])) {
            $filename = $configuration['title'];
        }

        if (isset($configuration['destination'])) {
            $destination = $configuration['destination'];
        }


        $template = $configuration['template'];


        if ($destination === 'inline') {
            return $this->inline($template, $filename, $configuration);
        }

        if ($destination === 'file') {
            return $this->file($template, $filename, $configuration, $settings);
        }

        throw new Exception('HI PDF Plugin - Invalid or no destination provided');
    }

    /**
     * @param string $template
     * @param string $filename
     * @param array $configuration
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \yii\base\Exception
     */
    private function inline(string $template, string $filename, array $configuration): string
    {
        $vars = [];

        if (isset($configuration['variables'])) {
            $vars['variables'] = $configuration['variables'];
        }

        if (isset($configuration['title'])) {
            $vars['title'] = $configuration['title'];
        }

        $html = Craft::$app->getView()->renderTemplate($template, $vars);
        $pdf = \Typesetsh\createPdf($html, \Typesetsh\UriResolver::all());

        Craft::$app->getResponse()->headers->set('Content-Type', 'application/pdf');
        Craft::$app->getResponse()->headers->set('Content-Transfer-Encoding', 'Binary');
        Craft::$app->getResponse()->headers->set('Content-disposition', 'inline; filename=' . $filename . '.pdf');


        return Craft::$app->getResponse()->data = $pdf->asString();
    }

    /**
     * @param string $template
     * @param string $filename
     * @param array $configuration
     * @param array $settings
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \craft\errors\MissingAssetException
     * @throws \craft\errors\VolumeException
     * @throws \craft\errors\VolumeObjectNotFoundException
     * @throws \yii\base\Exception
     */
    private function file(string $template, string $filename, array $configuration, Settings $settings): string
    {
        $vars = [];

        if (isset($configuration['variables'])) {
            $vars['variables'] = $configuration['variables'];
        }

        if (isset($configuration['title'])) {
            $vars['title'] = $configuration['title'];
        }

        $assetFolder = $settings['assetFolder'];
        $subFolder = $settings['subFolder'];

        $volume = Craft::$app->getVolumes()->getVolumeById($assetFolder);
        $volumePath = $volume->getFs()->getRootUrl();

        if ($subFolder) {
            // Check if subfolder exists
            Craft::$app->getAssets()->ensureFolderByFullPathAndVolume($subFolder, $volume, false);
            $path = $subFolder . '/' . $filename . '.pdf';
        } else {
            $path = $filename . '.pdf';
        }

        // Generate pdf and save to asset folder
        $html = Craft::$app->getView()->renderTemplate($template, $vars);
        $pdf = \Typesetsh\createPdf($html, \Typesetsh\UriResolver::all());
        $pdf->toFile($volumePath . '/' . $path);

        // Index asset to show up in the control panel
        $sessionId = Craft::$app->getAssetIndexer()->createIndexingSession([$volume])->id;

        Craft::$app->getAssetIndexer()->indexFile($volume, $path, $sessionId);

        // Return new asset url
        return Craft::$app->getResponse()->data = $volumePath . '/' . $path;
    }
}
