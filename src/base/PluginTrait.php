<?php

namespace hi_digital\hipdfgenerator\base;

use hi_digital\hipdfgenerator\libraries\Pdf;

trait PluginTrait
{
    public static $plugin;

    private function _setPluginComponents()
    {
        $this->setComponents([
            'pdf' => Pdf::class,
        ]);
    }

}