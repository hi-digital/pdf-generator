<?php
/**
 * HI PDF Generator plugin for Craft CMS 3.x
 *
 * Generates PDFs from templates with the typeset.sh library
 *
 * @link      https://bitbucket.org/hi-schweiz/
 * @copyright Copyright (c) 2022 HI Digital
 */

namespace hi_digital\hipdfgenerator\models;

use hi_digital\hipdfgenerator\HiPdfGenerator;

use Craft;
use craft\base\Model;

/**
 * @author    HI Digital
 * @package   HiPdfGenerator
 * @since     0.0.1
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $assetFolder = '';
    public $subFolder = '';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['assetFolder', 'string'],
            ['subFolder', 'string'],
        ];
    }
}
