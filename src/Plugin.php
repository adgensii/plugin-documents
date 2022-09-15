<?php

namespace Botble\Documents;

use Illuminate\Support\Facades\Schema;
use Botble\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('documents');
        Schema::dropIfExists('documents_translations');
    }
}
