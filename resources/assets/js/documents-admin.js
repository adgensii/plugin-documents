'use strict';

$(document).ready(function () {

    $('.btn_select_documents').rvMedia({
        filter: 'document',
        view_in: 'all_media',
        onSelectFiles: function (files) {
            var last_index = $('.list-documents .list-documents-item:last-child').data('id') + 1;
            $.each(files, function (index, file) {
                $('.list-documents .row').append('<div class="col-md-2 col-sm-3 col-4 list-documents-item" title="' + file.basename + '" data-id="' + (last_index + index) + '" data-basename="' + file.basename + '" data-document="' + file.url + '" data-description=""><div class="documents_image_wrapper"><i class="far fa-file-alt"></i><span>'+ file.basename +'</span></div></div>');
            });
            initSortable();
            updateItems();
            $('.reset-documents').removeClass('hidden');
        }
    });

    let initSortable = function () {
        let el = document.getElementById('list-documents-items');
        if (el) {
            Sortable.create(el, {
                group: 'documents', // or { name: "...", pull: [true, false, clone], put: [true, false, array] }
                sort: true, // sorting inside list
                delay: 0, // time in milliseconds to define when the sorting should start
                disabled: false, // Disables the sortable if set to true.
                store: null, // @see Store
                animation: 150, // ms, animation speed moving items when sorting, `0` — without animation
                handle: '.list-documents-item',
                ghostClass: 'sortable-ghost', // Class name for the drop placeholder
                chosenClass: 'sortable-chosen', // Class name for the chosen item
                dataIdAttr: 'data-id',

                forceFallback: false, // ignore the HTML5 DnD behaviour and force the fallback to kick in
                fallbackClass: 'sortable-fallback', // Class name for the cloned DOM Element when using forceFallback
                fallbackOnBody: false,  // Appends the cloned DOM Element into the Document's Body

                scroll: true, // or HTMLElement
                scrollSensitivity: 30, // px, how near the mouse must be to an edge to start scrolling.
                scrollSpeed: 10, // px

                // dragging ended
                onEnd: () => {
                    updateItems();
                }
            });
        }
    };

    initSortable();

    let updateItems = function () {
        let items = [];
        $.each($('.list-documents-item'), (index, widget) => {
            $(widget).data('id', index);
            items.push({basename: $(widget).data('basename'), document: $(widget).data('document'), description: $(widget).data('description')});
        });

        $('#documents-data').val(JSON.stringify(items));
    };

    let $listDocuments = $('.list-documents');
    let $editDocumentItem = $('#edit-document-item');

    $('.reset-documents').on('click', function (event) {
        event.preventDefault();
        $('.list-documents .list-documents-item').remove();
        updateItems();
        $(this).addClass('hidden');
    });

    $listDocuments.on('click', '.list-documents-item', function () {
        let id = $(this).data('id');
        $('#delete-document-item').data('id', id);
        $('#update-document-item').data('id', id);
        $('#document-item-description').val($(this).data('description'));
        $editDocumentItem.modal('show');
    });

    $editDocumentItem.on('click', '#delete-document-item', function (event) {
        event.preventDefault();
        $editDocumentItem.modal('hide');
        $listDocuments.find('.list-documents-item[data-id=' + $(this).data('id') + ']').remove();
        updateItems();
        if ($listDocuments.find('.list-documents-item').length === 0) {
            $('.reset-documents').addClass('hidden');
        }
    });

    $editDocumentItem.on('click', '#update-document-item', function (event) {
        event.preventDefault();
        $editDocumentItem.modal('hide');
        $listDocuments.find('.list-documents-item[data-id=' + $(this).data('id') + ']').data('description', $('#document-item-description').val());
        updateItems();
    });
});
