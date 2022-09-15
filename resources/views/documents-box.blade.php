{!! Form::hidden('documents', $value ? json_encode($value) : null, ['id' => 'documents-data', 'class' => 'form-control']) !!}
<div>
    <div class="list-documents">
        <div class="row" id="list-documents-items">
            @if (!empty($value))
                @foreach ($value as $key => $item)
                    <div class="col-md-2 col-sm-3 col-4 list-documents-item" title="{{ Arr::get($item, 'basename') }}" data-id="{{ $key }}" data-basename="{{ Arr::get($item, 'basename') }}" data-document="{{ Arr::get($item, 'document') }}" data-description="{{ Arr::get($item, 'description') }}">
                        <div class="documents_image_wrapper">
                            <i class="far fa-file-alt"></i>
                            <span>{{ Arr::get($item, 'basename') }}</span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group mb-3">
        <a href="#" class="btn_select_documents">{{ trans('plugins/documents::documents.select_documents') }}</a>&nbsp;
        <a href="#" class="text-danger reset-documents @if (empty($value)) hidden @endif">{{ trans('plugins/documents::documents.reset') }}</a>
    </div>
</div>

<div id="edit-document-item" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title"><i class="til_img"></i><strong>{{ trans('plugins/documents::documents.update_document_description') }}</strong></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>

            <div class="modal-body with-padding">
                <p><input type="text" class="form-control" id="document-item-description" placeholder="{{ trans('plugins/documents::documents.update_document_description_placeholder') }}"></p>
            </div>

            <div class="modal-footer">
                <button class="float-start btn btn-danger" type="button" id="delete-document-item">{{ trans('plugins/documents::documents.delete_document') }}</button>
                <button class="float-end btn btn-secondary" type="button" data-bs-dismiss="modal">{{ trans('core/base::forms.cancel') }}</button>
                <button class="float-end btn btn-primary" type="button" id="update-document-item">{{ trans('core/base::forms.update') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- end Modal -->
