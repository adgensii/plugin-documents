<?php

namespace Botble\Documents\Providers;

use Illuminate\Support\ServiceProvider;
use Botble\Documents\Models\DocumentsMeta;
use Botble\Documents\Repositories\Caches\DocumentsMetaCacheDecorator;
use Botble\Documents\Repositories\Eloquent\DocumentsMetaRepository;
use Botble\Documents\Repositories\Interfaces\DocumentsMetaInterface;
use Botble\Documents\Facades\DocumentsFacade;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Event;
use Illuminate\Routing\Events\RouteMatched;
use Language;
use Documents;

class DocumentsServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(DocumentsMetaInterface::class, function () {
            return new DocumentsMetaCacheDecorator(new DocumentsMetaRepository(new DocumentsMeta));
        });

        $this->setNamespace('plugins/documents')->loadHelpers();

        AliasLoader::getInstance()->alias('Documents', DocumentsFacade::class);
    }

    public function boot()
    {
        $this
            ->loadAndPublishConfigurations(['general'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadMigrations()
            ->publishAssets();

        $this->app->register(EventServiceProvider::class);

        $useLanguageV2 = $this->app['config']->get('plugins.documents.general.use_language_v2', false) &&
            defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME');

        if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
            if ($useLanguageV2) {

                LanguageAdvancedManager::registerModule(DocumentsMeta::class, [
                    'images',
                ]);

                LanguageAdvancedManager::addTranslatableMetaBox('documents_wrap');

                foreach (\Documents::getSupportedModules() as $item) {
                    $translatableColumns = array_merge(
                        LanguageAdvancedManager::getTranslatableColumns($item),
                        ['documents']
                    );

                    LanguageAdvancedManager::registerModule($item, $translatableColumns);
                }
            } else {
                $this->app->booted(function () {
                    Language::registerModule([Documents::class]);
                });
            }
        }

        $this->app->booted(function () {
            $this->app->register(HookServiceProvider::class);
        });
    }
}
