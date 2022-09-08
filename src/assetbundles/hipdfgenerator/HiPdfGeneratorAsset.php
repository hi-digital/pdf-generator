<?php
/**
 * HI PDF Generator plugin for Craft CMS 3.x
 *
 * Generates PDFs from templates with the typeset.sh library
 *
 * @link      https://bitbucket.org/hi-schweiz/
 * @copyright Copyright (c) 2022 HI Digital
 */

namespace hi_digital\hipdfgenerator\assetbundles\hipdfgenerator;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    HI Digital
 * @package   HiPdfGenerator
 * @since     0.0.1
 */
class HiPdfGeneratorAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@hi_digital/hipdfgenerator/assetbundles/hipdfgenerator/dist";

        $this->depends = [
            CpAsset::class,
        ];

        parent::init();
    }
}
