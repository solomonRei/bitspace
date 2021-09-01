$(document).ready(function() {
    document.addEventListener('DOMContentLoaded', () => {
    });

    /*=============================================
    =            Custom select                   =
    =============================================*/
    /* Generate custom select */
    const selects = Array.from(document.getElementsByClassName('custom-select'));
    function createCustomSelect(select) {
        const classes = select.getAttribute('class');
        const options = Array.from(select.getElementsByTagName('option'));
        const wrapper = createEl("div", "custom-select-wrapper");
        const span = createEl("span", "custom-select-trigger");
        const options_wrapper = createEl("div", "custom-options");
        const template = createTemplate(classes, span);

        span.innerText = select.value 
            ? select.options[select.selectedIndex].text 
            : select.getAttribute("placeholder");

        generateOptions(options, options_wrapper, select.value);

        template.appendChild(options_wrapper);
        wrap(select, wrapper);
        select.after(template);
    };

    const inputEvent = new Event('input', {
        bubbles: true,
        cancelable: true,
    });

    selects.forEach((select) => createCustomSelect(select));

    /* Add event on clicked select */
    const triggers = Array.from(document.getElementsByClassName('custom-select-trigger'));

    triggers.forEach((trigger) => {
        trigger.addEventListener("click", () => {
            trigger.parentNode.classList.toggle("opened");

        })
    });

    /* Add event on clicked option */
    const customOptions = Array.from(document.getElementsByClassName('custom-option'));

    customOptions.forEach((option) => {
        option.addEventListener("click", () => {
            const customSelect = findAncestor(option, "custom-select");
            const select = customSelect.previousSibling;
            const trigger = findAncestor(option, "custom-options").previousSibling;

            select.value = option.getAttribute("data-value");
            select.dispatchEvent(inputEvent);
            customSelect.classList.toggle("opened");
            trigger.innerText = option.innerText;

        })
    });

    function findAncestor(el, cls) {
        while ((el = el.parentNode) && !el.classList.contains(cls)) ;
        return el;
    }

    function generateOptions(options, wrapper, selectedValue) {
        options.forEach((option) => {
            const html_option = document.createElement('span');
            html_option.classList.add(`custom-option`);
            html_option.setAttribute("data-value", option.getAttribute("value"));
            html_option.innerText = option.innerText;
            wrapper.appendChild(html_option);
        });
    }

    function createEl(node, classes) {
        const el = document.createElement(node);
        el.classList.add(classes);
        return el;
    }

    function createTemplate(classes, child) {
        const template = document.createElement('div');
        template.classList.add(classes);
        template.appendChild(child);
        return template;
    }

    function wrap(el, wrapper) {
        el.parentNode.insertBefore(wrapper, el);
        wrapper.appendChild(el);
    }

    function handleFileSelect(files, className) {
        for (let i = 0; i < files.length; i++) {
            if (!files[i].type.match('image.*')) {
                toastr.error("Загрузите изображение");
            }
            let reader = new FileReader();

            reader.onload = (function (theFile) {
                return function (e) {
                    $('<div class="preview-video red"><div class="preview-video_image"><img src="'+ e.target.result +'" alt=""></div><div class="preview-video_cancel"></div></div>').insertBefore('.'+className);
                    switch (className) {
                        case 'thumb-add-ru':
                        case 'thumb-add-en':
                        case 'thumb-add-kz':
                            $('.'+className).css('display', 'none');
                    }
                };
            })(files[i]);

            reader.readAsDataURL(files[i]);
        }
    }

});

/*=====  End of Custom select         ======*/
