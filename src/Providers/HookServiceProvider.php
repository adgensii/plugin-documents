<?php

namespace Botble\Documents\Providers;

use Assets;
use Botble\Base\Models\BaseModel;
use Documents;
use Illuminate\Support\ServiceProvider;
use MetaBox;
use Throwable;

class HookServiceProvider extends ServiceProvider
{
    /**
     * @throws Throwable
     */
    public function boot()
    {
        add_action(BASE_ACTION_META_BOXES, [$this, 'addDocumentsBox'], 13, 2);
    }

    /**
     * @param string $context
     * @param BaseModel $object
     */
    public function addDocumentsBox($context, $object)
    {
        if ($object && in_array(get_class($object), Documents::getSupportedModules()) && $context == 'advanced') {
            Assets::addStylesDirectly(['vendor/core/plugins/documents/css/admin-documents.css'])
            ->addScriptsDirectly(['vendor/core/plugins/documents/js/documents-admin.js'])
            ->addScripts(['sortable']);
            
            MetaBox::addMetaBox(
                'documents_wrap',
                trans('plugins/documents::documents.documents_box'),
                [$this, 'documentsMetaField'],
                get_class($object),
                $context
            );
        }
    }
    
    /**
     * @return string
     * @throws Throwable
     */
    public function documentsMetaField()
    {
        $value = null;
        $args = func_get_args();

        if ($args[0] && $args[0]->id) {
            $value = documents_meta_data($args[0]);
        }

        return view('plugins/documents::documents-box', compact('value'))->render();
    }

}