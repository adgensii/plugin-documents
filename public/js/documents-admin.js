/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./platform/plugins/documents/resources/assets/js/documents-admin.js":
/*!***************************************************************************!*\
  !*** ./platform/plugins/documents/resources/assets/js/documents-admin.js ***!
  \***************************************************************************/
/***/ (() => {



$(document).ready(function () {
  $('.btn_select_documents').rvMedia({
    filter: 'document',
    view_in: 'all_media',
    onSelectFiles: function onSelectFiles(files) {
      var last_index = $('.list-documents .list-documents-item:last-child').data('id') + 1;
      $.each(files, function (index, file) {
        $('.list-documents .row').append('<div class="col-md-2 col-sm-3 col-4 list-documents-item" title="' + file.basename + '" data-id="' + (last_index + index) + '" data-basename="' + file.basename + '" data-document="' + file.url + '" data-description=""><div class="documents_image_wrapper"><i class="far fa-file-alt"></i><span>' + file.basename + '</span></div></div>');
      });
      initSortable();
      updateItems();
      $('.reset-documents').removeClass('hidden');
    }
  });

  var initSortable = function initSortable() {
    var el = document.getElementById('list-documents-items');

    if (el) {
      Sortable.create(el, {
        group: 'documents',
        // or { name: "...", pull: [true, false, clone], put: [true, false, array] }
        sort: true,
        // sorting inside list
        delay: 0,
        // time in milliseconds to define when the sorting should start
        disabled: false,
        // Disables the sortable if set to true.
        store: null,
        // @see Store
        animation: 150,
        // ms, animation speed moving items when sorting, `0` — without animation
        handle: '.list-documents-item',
        ghostClass: 'sortable-ghost',
        // Class name for the drop placeholder
        chosenClass: 'sortable-chosen',
        // Class name for the chosen item
        dataIdAttr: 'data-id',
        forceFallback: false,
        // ignore the HTML5 DnD behaviour and force the fallback to kick in
        fallbackClass: 'sortable-fallback',
        // Class name for the cloned DOM Element when using forceFallback
        fallbackOnBody: false,
        // Appends the cloned DOM Element into the Document's Body
        scroll: true,
        // or HTMLElement
        scrollSensitivity: 30,
        // px, how near the mouse must be to an edge to start scrolling.
        scrollSpeed: 10,
        // px
        // dragging ended
        onEnd: function onEnd() {
          updateItems();
        }
      });
    }
  };

  initSortable();

  var updateItems = function updateItems() {
    var items = [];
    $.each($('.list-documents-item'), function (index, widget) {
      $(widget).data('id', index);
      items.push({
        basename: $(widget).data('basename'),
        document: $(widget).data('document'),
        description: $(widget).data('description')
      });
    });
    $('#documents-data').val(JSON.stringify(items));
  };

  var $listDocuments = $('.list-documents');
  var $editDocumentItem = $('#edit-document-item');
  $('.reset-documents').on('click', function (event) {
    event.preventDefault();
    $('.list-documents .list-documents-item').remove();
    updateItems();
    $(this).addClass('hidden');
  });
  $listDocuments.on('click', '.list-documents-item', function () {
    var id = $(this).data('id');
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

/***/ }),

/***/ "./platform/plugins/documents/resources/assets/sass/admin-documents.scss":
/*!*******************************************************************************!*\
  !*** ./platform/plugins/documents/resources/assets/sass/admin-documents.scss ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/vendor/core/plugins/documents/js/documents-admin": 0,
/******/ 			"vendor/core/plugins/documents/css/admin-documents": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["vendor/core/plugins/documents/css/admin-documents"], () => (__webpack_require__("./platform/plugins/documents/resources/assets/js/documents-admin.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["vendor/core/plugins/documents/css/admin-documents"], () => (__webpack_require__("./platform/plugins/documents/resources/assets/sass/admin-documents.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;