<?php

namespace Botble\Documents\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Documents\Http\Requests\DocumentsRequest;
use Botble\Documents\Repositories\Interfaces\DocumentsInterface;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Botble\Documents\Tables\DocumentsTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Documents\Forms\DocumentsForm;
use Botble\Base\Forms\FormBuilder;

class DocumentsController extends BaseController
{
    /**
     * @var DocumentsInterface
     */
    protected $documentsRepository;

    /**
     * @param DocumentsInterface $documentsRepository
     */
    public function __construct(DocumentsInterface $documentsRepository)
    {
        $this->documentsRepository = $documentsRepository;
    }

    /**
     * @param DocumentsTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(DocumentsTable $table)
    {
        page_title()->setTitle(trans('plugins/documents::documents.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/documents::documents.create'));

        return $formBuilder->create(DocumentsForm::class)->renderForm();
    }

    /**
     * @param DocumentsRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(DocumentsRequest $request, BaseHttpResponse $response)
    {
        $documents = $this->documentsRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(DOCUMENTS_MODULE_SCREEN_NAME, $request, $documents));

        return $response
            ->setPreviousUrl(route('documents.index'))
            ->setNextUrl(route('documents.edit', $documents->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $documents = $this->documentsRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $documents));

        page_title()->setTitle(trans('plugins/documents::documents.edit') . ' "' . $documents->name . '"');

        return $formBuilder->create(DocumentsForm::class, ['model' => $documents])->renderForm();
    }

    /**
     * @param int $id
     * @param DocumentsRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, DocumentsRequest $request, BaseHttpResponse $response)
    {
        $documents = $this->documentsRepository->findOrFail($id);

        $documents->fill($request->input());

        $documents = $this->documentsRepository->createOrUpdate($documents);

        event(new UpdatedContentEvent(DOCUMENTS_MODULE_SCREEN_NAME, $request, $documents));

        return $response
            ->setPreviousUrl(route('documents.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $documents = $this->documentsRepository->findOrFail($id);

            $this->documentsRepository->delete($documents);

            event(new DeletedContentEvent(DOCUMENTS_MODULE_SCREEN_NAME, $request, $documents));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $documents = $this->documentsRepository->findOrFail($id);
            $this->documentsRepository->delete($documents);
            event(new DeletedContentEvent(DOCUMENTS_MODULE_SCREEN_NAME, $request, $documents));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
