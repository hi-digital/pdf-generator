<?php
/**
 * HI PDF Generator plugin for Craft CMS 4.x
 *
 * Generates PDF from templates
 *
 * @link      https://bitbucket.org/hi-schweiz/
 * @copyright Copyright (c) 2023 HI Digital
 */

namespace hi_digital\hipdfgenerator\variables;

use hi_digital\hipdfgenerator\HiPdfGenerator as Generator;

/**
 * @author    HI Digital
 * @package   HiPdfGenerator
 * @since     0.0.1
 */
class HiPdfGeneratorVariable
{
    // Public Methods
    // =========================================================================
    /**
     * Plugin variable for generating PDFs
     * @param array $configuration
     * @return string
     */
    public function generatePdf(array $configuration): string
    {
        return Generator::$plugin->pdf->generatePdf($configuration);
    }
}
