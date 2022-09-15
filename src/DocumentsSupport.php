<?php

namespace Botble\Documents;

use Botble\Documents\Repositories\Interfaces\DocumentsMetaInterface;
use Botble\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Language;

class DocumentsSupport
{

    /**
     * @var DocumentsMetaInterface
     */
    protected $documentsMetaRepository;

    /**
     * Gallery constructor.
     * @param DocumentsMetaInterface $documentsMetaRepository
     */
    public function __construct(DocumentsMetaInterface $documentsMetaRepository)
    {
        $this->documentsMetaRepository = $documentsMetaRepository;
    }

    /**
     * @param string | array $model
     * @return DocumentsSupport
     */
    public function registerModule($model): DocumentsSupport
    {
        if (!is_array($model)) {
            $model = [$model];
        }

        config([
            'plugins.documents.general.supported' => array_merge($this->getSupportedModules(), $model),
        ]);

        return $this;
    }

    /**
     * @return array
     */
    public function getSupportedModules(): array
    {
        return config('plugins.documents.general.supported', []);
    }

    /**
     * @param string | array $model
     * @return DocumentsSupport
     */
    public function removeModule($model): DocumentsSupport
    {
        $models = $this->getSupportedModules();

        foreach ($this->getSupportedModules() as $key => $item) {
            if ($item == $model) {
                Arr::forget($models, $key);
                break;
            }
        }

        config(['plugins.documents.general.supported' => $models]);

        return $this;
    }
    
    /**
     * @param Request $request
     * @param BaseModel $data
     * @throws Exception
     */
    public function saveDocumentsList($request, $data)
    {
        if ($data && in_array(get_class($data), $this->getSupportedModules()) && $request->has('documents')) {
            $meta = $this->documentsMetaRepository->getFirstBy([
                'reference_id'   => $data->id,
                'reference_type' => get_class($data),
            ]);
            
            $currentLanguage = $request->input('ref_lang');
            
            if (defined('LANGUAGE_MODULE_SCREEN_NAME') && $currentLanguage && $currentLanguage != Language::getDefaultLocaleCode()) {
                $formRequest = new Request();
                $formRequest->replace([
                    'language'      => $request->input('language'),
                    'ref_lang'      => $currentLanguage,
                    'documents'     => $request->input('documents'),
                ]);

                if (!$meta) {
                    $meta = $this->documentsMetaRepository->getModel();
                    $meta->reference_id = $data->id;
                    $meta->reference_type = get_class($data);
                    $meta->documents = json_decode($request->input('documents'), true);
                    $meta->save();
                }

                LanguageAdvancedManager::save($meta, $formRequest);
            } else {
                if (empty($meta->documents)) {
                    $this->deleteDocumentsList($data);
                }

                if (!$meta) {
                    $meta = $this->documentsMetaRepository->getModel();
                    $meta->reference_id = $data->id;
                    $meta->reference_type = get_class($data);
                }
                
                $meta->documents = json_decode($request->input('documents'), true);

                $this->documentsMetaRepository->createOrUpdate($meta);
            }
        }
    }

    /**
     * @param BaseModel $data
     * @return bool
     * @throws Exception
     */
    public function deleteDocumentsList($data): bool
    {
        if (in_array(get_class($data), $this->getSupportedModules())) {
            $this->documentsMetaRepository->deleteBy([
                'reference_id'   => $data->id,
                'reference_type' => get_class($data),
            ]);
        }

        return true;
    }
}
