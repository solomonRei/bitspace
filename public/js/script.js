/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/script.js":
/*!********************************!*\
  !*** ./resources/js/script.js ***!
  \********************************/
/***/ (() => {

$(document).ready(function () {
  document.addEventListener('DOMContentLoaded', function () {});
  /*=============================================
  =            Custom select                   =
  =============================================*/

  /* Generate custom select */

  var selects = Array.from(document.getElementsByClassName('custom-select'));
  selects.forEach(function (select) {
    var classes = select.getAttribute('class');
    var options = Array.from(select.getElementsByTagName('option'));
    var wrapper = createEl("div", "custom-select-wrapper");
    var span = createEl("span", "custom-select-trigger");
    var options_wrapper = createEl("div", "custom-options");
    var template = createTemplate(classes, span);
    span.innerText = select.getAttribute("placeholder");
    generateOptions(options, options_wrapper);
    template.appendChild(options_wrapper);
    wrap(select, wrapper);
    select.after(template);
  });
  /* Add event on clicked select */

  var triggers = Array.from(document.getElementsByClassName('custom-select-trigger'));
  triggers.forEach(function (trigger) {
    trigger.addEventListener("click", function () {
      trigger.parentNode.classList.toggle("opened");
    });
  });
  /* Add event on clicked option */

  var customOptions = Array.from(document.getElementsByClassName('custom-option'));
  customOptions.forEach(function (option) {
    option.addEventListener("click", function () {
      var customSelect = findAncestor(option, "custom-select");
      var select = customSelect.previousSibling;
      var trigger = findAncestor(option, "custom-options").previousSibling;
      select.value = option.getAttribute("data-value");
      customSelect.classList.toggle("opened");
      trigger.innerText = option.innerText;
    });
  });

  function findAncestor(el, cls) {
    while ((el = el.parentNode) && !el.classList.contains(cls)) {
      ;
    }

    return el;
  }

  function generateOptions(options, wrapper) {
    options.forEach(function (option) {
      var html_option = document.createElement('span');
      html_option.classList.add("custom-option");
      html_option.setAttribute("data-value", option.getAttribute("value"));
      html_option.innerText = option.innerText;
      wrapper.appendChild(html_option);
    });
  }

  function createEl(node, classes) {
    var el = document.createElement(node);
    el.classList.add(classes);
    return el;
  }

  function createTemplate(classes, child) {
    var template = document.createElement('div');
    template.classList.add(classes);
    template.appendChild(child);
    return template;
  }

  function wrap(el, wrapper) {
    el.parentNode.insertBefore(wrapper, el);
    wrapper.appendChild(el);
  }

  function handleFileSelect(files, className) {
    for (var i = 0; i < files.length; i++) {
      if (!files[i].type.match('image.*')) {
        toastr.error("Загрузите изображение");
      }

      var reader = new FileReader();

      reader.onload = function (theFile) {
        return function (e) {
          $('<div class="preview-video red"><div class="preview-video_image"><img src="' + e.target.result + '" alt=""></div><div class="preview-video_cancel"></div></div>').insertBefore('.' + className);

          switch (className) {
            case 'thumb-add-ru':
            case 'thumb-add-en':
            case 'thumb-add-kz':
              $('.' + className).css('display', 'none');
          }
        };
      }(files[i]);

      reader.readAsDataURL(files[i]);
    }
  }
});
/*=====  End of Custom select         ======*/

/***/ }),

/***/ "./resources/vendor/css/simplelightbox.scss":
/*!**************************************************!*\
  !*** ./resources/vendor/css/simplelightbox.scss ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/css/style.scss":
/*!**********************************!*\
  !*** ./resources/css/style.scss ***!
  \**********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
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
/******/ 					result = fn();
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
/******/ 			"/js/script": 0,
/******/ 			"css/app": 0,
/******/ 			"vendor/css/vendor": 0
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
/******/ 			for(moduleId in moreModules) {
/******/ 				if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 					__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 				}
/******/ 			}
/******/ 			if(runtime) runtime(__webpack_require__);
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkIds[i]] = 0;
/******/ 			}
/******/ 			__webpack_require__.O();
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
/******/ 	__webpack_require__.O(undefined, ["css/app","vendor/css/vendor"], () => (__webpack_require__("./resources/js/script.js")))
/******/ 	__webpack_require__.O(undefined, ["css/app","vendor/css/vendor"], () => (__webpack_require__("./resources/vendor/css/simplelightbox.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app","vendor/css/vendor"], () => (__webpack_require__("./resources/css/style.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;