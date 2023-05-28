(() => {
    "use strict";
    const flsModules = {};
    function isWebp() {
        function testWebP(callback) {
            let webP = new Image;
            webP.onload = webP.onerror = function() {
                callback(webP.height == 2);
            };
            webP.src = "data:image/webp;base64,UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA";
        }
        testWebP((function(support) {
            let className = support === true ? "webp" : "no-webp";
            document.documentElement.classList.add(className);
        }));
    }
    let bodyLockStatus = true;
    let bodyLockToggle = (delay = 500) => {
        if (document.documentElement.classList.contains("lock")) bodyUnlock(delay); else bodyLock(delay);
    };
    let bodyUnlock = (delay = 500) => {
        let body = document.querySelector("body");
        if (bodyLockStatus) {
            let lock_padding = document.querySelectorAll("[data-lp]");
            setTimeout((() => {
                for (let index = 0; index < lock_padding.length; index++) {
                    const el = lock_padding[index];
                    el.style.paddingRight = "0px";
                }
                body.style.paddingRight = "0px";
                document.documentElement.classList.remove("lock");
            }), delay);
            bodyLockStatus = false;
            setTimeout((function() {
                bodyLockStatus = true;
            }), delay);
        }
    };
    let bodyLock = (delay = 500) => {
        let body = document.querySelector("body");
        if (bodyLockStatus) {
            let lock_padding = document.querySelectorAll("[data-lp]");
            for (let index = 0; index < lock_padding.length; index++) {
                const el = lock_padding[index];
                el.style.paddingRight = window.innerWidth - document.querySelector(".wrapper").offsetWidth + "px";
            }
            body.style.paddingRight = window.innerWidth - document.querySelector(".wrapper").offsetWidth + "px";
            document.documentElement.classList.add("lock");
            bodyLockStatus = false;
            setTimeout((function() {
                bodyLockStatus = true;
            }), delay);
        }
    };
    function menuInit() {
        if (document.querySelector(".icon-menu")) document.addEventListener("click", (function(e) {
            if (bodyLockStatus && e.target.closest(".icon-menu")) {
                bodyLockToggle();
                document.documentElement.classList.toggle("menu-open");
            }
        }));
    }
    function menuClose() {
        bodyUnlock();
        document.documentElement.classList.remove("menu-open");
    }
    function FLS(message) {
        setTimeout((() => {
            if (window.FLS) console.log(message);
        }), 0);
    }
    let gotoBlock = (targetBlock, noHeader = false, speed = 500, offsetTop = 0) => {
        const targetBlockElement = document.querySelector(targetBlock);
        if (targetBlockElement) {
            let headerItem = "";
            let headerItemHeight = 0;
            if (noHeader) {
                headerItem = "header.header";
                const headerElement = document.querySelector(headerItem);
                if (!headerElement.classList.contains("_header-scroll")) {
                    headerElement.style.cssText = `transition-duration: 0s;`;
                    headerElement.classList.add("_header-scroll");
                    headerItemHeight = headerElement.offsetHeight;
                    headerElement.classList.remove("_header-scroll");
                    setTimeout((() => {
                        headerElement.style.cssText = ``;
                    }), 0);
                } else headerItemHeight = headerElement.offsetHeight;
            }
            let options = {
                speedAsDuration: true,
                speed,
                header: headerItem,
                offset: offsetTop,
                easing: "easeOutQuad"
            };
            document.documentElement.classList.contains("menu-open") ? menuClose() : null;
            if (typeof SmoothScroll !== "undefined") (new SmoothScroll).animateScroll(targetBlockElement, "", options); else {
                let targetBlockElementPosition = targetBlockElement.getBoundingClientRect().top + scrollY;
                targetBlockElementPosition = headerItemHeight ? targetBlockElementPosition - headerItemHeight : targetBlockElementPosition;
                targetBlockElementPosition = offsetTop ? targetBlockElementPosition - offsetTop : targetBlockElementPosition;
                window.scrollTo({
                    top: targetBlockElementPosition,
                    behavior: "smooth"
                });
            }
            FLS(`[gotoBlock]: Юхуу...едем к ${targetBlock}`);
        } else FLS(`[gotoBlock]: Ой ой..Такого блока нет на странице: ${targetBlock}`);
    };
    function formFieldsInit(options = {
        viewPass: false,
        autoHeight: false
    }) {
        const formFields = document.querySelectorAll("input[placeholder],textarea[placeholder]");
        if (formFields.length) formFields.forEach((formField => {
            if (!formField.hasAttribute("data-placeholder-nohide")) formField.dataset.placeholder = formField.placeholder;
        }));
        document.body.addEventListener("focusin", (function(e) {
            const targetElement = e.target;
            if (targetElement.tagName === "INPUT" || targetElement.tagName === "TEXTAREA") {
                if (targetElement.dataset.placeholder) targetElement.placeholder = "";
                if (!targetElement.hasAttribute("data-no-focus-classes")) {
                    targetElement.classList.add("_form-focus");
                    targetElement.parentElement.classList.add("_form-focus");
                }
                formValidate.removeError(targetElement);
            }
        }));
        document.body.addEventListener("focusout", (function(e) {
            const targetElement = e.target;
            if (targetElement.tagName === "INPUT" || targetElement.tagName === "TEXTAREA") {
                if (targetElement.dataset.placeholder) targetElement.placeholder = targetElement.dataset.placeholder;
                if (!targetElement.hasAttribute("data-no-focus-classes")) {
                    targetElement.classList.remove("_form-focus");
                    targetElement.parentElement.classList.remove("_form-focus");
                }
                if (targetElement.hasAttribute("data-validate")) formValidate.validateInput(targetElement);
            }
        }));
        if (options.viewPass) document.addEventListener("click", (function(e) {
            let targetElement = e.target;
            if (targetElement.closest('[class*="__viewpass"]')) {
                let inputType = targetElement.classList.contains("_viewpass-active") ? "password" : "text";
                targetElement.parentElement.querySelector("input").setAttribute("type", inputType);
                targetElement.classList.toggle("_viewpass-active");
            }
        }));
        if (options.autoHeight) {
            const textareas = document.querySelectorAll("textarea[data-autoheight]");
            if (textareas.length) {
                textareas.forEach((textarea => {
                    const startHeight = textarea.hasAttribute("data-autoheight-min") ? Number(textarea.dataset.autoheightMin) : Number(textarea.offsetHeight);
                    const maxHeight = textarea.hasAttribute("data-autoheight-max") ? Number(textarea.dataset.autoheightMax) : 1 / 0;
                    setHeight(textarea, Math.min(startHeight, maxHeight));
                    textarea.addEventListener("input", (() => {
                        if (textarea.scrollHeight > startHeight) {
                            textarea.style.height = `auto`;
                            setHeight(textarea, Math.min(Math.max(textarea.scrollHeight, startHeight), maxHeight));
                        }
                    }));
                }));
                function setHeight(textarea, height) {
                    textarea.style.height = `${height}px`;
                }
            }
        }
    }
    let formValidate = {
        getErrors(form) {
            let error = 0;
            let formRequiredItems = form.querySelectorAll("*[data-required]");
            if (formRequiredItems.length) formRequiredItems.forEach((formRequiredItem => {
                if ((formRequiredItem.offsetParent !== null || formRequiredItem.tagName === "SELECT") && !formRequiredItem.disabled) error += this.validateInput(formRequiredItem);
            }));
            return error;
        },
        validateInput(formRequiredItem) {
            let error = 0;
            if (formRequiredItem.dataset.required === "email") {
                formRequiredItem.value = formRequiredItem.value.replace(" ", "");
                if (this.emailTest(formRequiredItem)) {
                    this.addError(formRequiredItem);
                    error++;
                } else this.removeError(formRequiredItem);
            } else if (formRequiredItem.type === "checkbox" && !formRequiredItem.checked) {
                this.addError(formRequiredItem);
                error++;
            } else if (!formRequiredItem.value.trim()) {
                this.addError(formRequiredItem);
                error++;
            } else this.removeError(formRequiredItem);
            return error;
        },
        addError(formRequiredItem) {
            formRequiredItem.classList.add("_form-error");
            formRequiredItem.parentElement.classList.add("_form-error");
            let inputError = formRequiredItem.parentElement.querySelector(".form__error");
            if (inputError) formRequiredItem.parentElement.removeChild(inputError);
            if (formRequiredItem.dataset.error) formRequiredItem.parentElement.insertAdjacentHTML("beforeend", `<div class="form__error">${formRequiredItem.dataset.error}</div>`);
        },
        removeError(formRequiredItem) {
            formRequiredItem.classList.remove("_form-error");
            formRequiredItem.parentElement.classList.remove("_form-error");
            if (formRequiredItem.parentElement.querySelector(".form__error")) formRequiredItem.parentElement.removeChild(formRequiredItem.parentElement.querySelector(".form__error"));
        },
        formClean(form) {
            form.reset();
            setTimeout((() => {
                let inputs = form.querySelectorAll("input,textarea");
                for (let index = 0; index < inputs.length; index++) {
                    const el = inputs[index];
                    el.parentElement.classList.remove("_form-focus");
                    el.classList.remove("_form-focus");
                    formValidate.removeError(el);
                }
                let checkboxes = form.querySelectorAll(".checkbox__input");
                if (checkboxes.length > 0) for (let index = 0; index < checkboxes.length; index++) {
                    const checkbox = checkboxes[index];
                    checkbox.checked = false;
                }
                if (flsModules.select) {
                    let selects = form.querySelectorAll(".select");
                    if (selects.length) for (let index = 0; index < selects.length; index++) {
                        const select = selects[index].querySelector("select");
                        flsModules.select.selectBuild(select);
                    }
                }
            }), 0);
        },
        emailTest(formRequiredItem) {
            return !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/.test(formRequiredItem.value);
        }
    };
    function formSubmit() {
        const forms = document.forms;
        if (forms.length) for (const form of forms) {
            form.addEventListener("submit", (function(e) {
                const form = e.target;
                formSubmitAction(form, e);
            }));
            form.addEventListener("reset", (function(e) {
                const form = e.target;
                formValidate.formClean(form);
            }));
        }
        async function formSubmitAction(form, e) {
            const error = !form.hasAttribute("data-no-validate") ? formValidate.getErrors(form) : 0;
            if (error === 0) {
                const ajax = form.hasAttribute("data-ajax");
                if (ajax) {
                    e.preventDefault();
                    const formAction = form.getAttribute("action") ? form.getAttribute("action").trim() : "#";
                    const formMethod = form.getAttribute("method") ? form.getAttribute("method").trim() : "GET";
                    const formData = new FormData(form);
                    form.classList.add("_sending");
                    const response = await fetch(formAction, {
                        method: formMethod,
                        body: formData
                    });
                    if (response.ok) {
                        let responseResult = await response.json();
                        form.classList.remove("_sending");
                        formSent(form, responseResult);
                    } else {
                        alert("Ошибка");
                        form.classList.remove("_sending");
                    }
                } else if (form.hasAttribute("data-dev")) {
                    e.preventDefault();
                    formSent(form);
                }
            } else {
                e.preventDefault();
                if (form.querySelector("._form-error") && form.hasAttribute("data-goto-error")) {
                    const formGoToErrorClass = form.dataset.gotoError ? form.dataset.gotoError : "._form-error";
                    gotoBlock(formGoToErrorClass, true, 1e3);
                }
            }
        }
        function formSent(form, responseResult = ``) {
            document.dispatchEvent(new CustomEvent("formSent", {
                detail: {
                    form
                }
            }));
            setTimeout((() => {
                if (flsModules.popup) {
                    const popup = form.dataset.popupMessage;
                    popup ? flsModules.popup.open(popup) : null;
                }
            }), 0);
            formValidate.formClean(form);
            formLogging(`Форма отправлена!`);
        }
        function formLogging(message) {
            FLS(`[Формы]: ${message}`);
        }
    }
    function formQuantity() {
        document.addEventListener("click", (function(e) {
            let targetElement = e.target;
            if (targetElement.closest("[data-quantity-plus]") || targetElement.closest("[data-quantity-minus]")) {
                const valueElement = targetElement.closest("[data-quantity]").querySelector("[data-quantity-value]");
                let value = parseInt(valueElement.value);
                if (targetElement.hasAttribute("data-quantity-plus")) {
                    value++;
                    if (+valueElement.dataset.quantityMax && +valueElement.dataset.quantityMax < value) value = valueElement.dataset.quantityMax;
                } else {
                    --value;
                    if (+valueElement.dataset.quantityMin) {
                        if (+valueElement.dataset.quantityMin > value) value = valueElement.dataset.quantityMin;
                    } else if (value < 1) value = 1;
                }
                targetElement.closest("[data-quantity]").querySelector("[data-quantity-value]").value = value;
            }
        }));
    }
    const baseUrl = "https://static.welesgard.com/delivery/frontend/web/api/";
    async function getData(endpoint, params = {}) {
        const url = new URL(baseUrl + endpoint);
        if (params.hasOwnProperty("shopIds")) url.searchParams.append("shopIds", params.shopIds.toString());
        try {
            const response = await fetch(url);
            if (!response.ok) {
                const message = `An error has occured: ${response.status} - ${response.url}`;
                throw new Error(message);
            }
            return await response.json();
        } catch (error) {
            console.error(error);
        }
    }
    async function postData(endpoint, data = {}) {
        const url = new URL(baseUrl + endpoint);
        try {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            });
            if (!response.ok) {
                const message = `An error has occured: ${response.status} - ${response.url}`;
                throw new Error(message);
            }
            return await response.json();
        } catch (error) {
            console.error(error);
        }
    }
    class Filter {
        constructor(filter) {
            this.id = filter.id;
            this.title = filter.title;
            this.coord = filter.coords;
            this._renderCheckBox();
        }
        _renderCheckBox() {
            const filtersCont = document.querySelector(".filters__list");
            const li = document.createElement("li");
            li.classList.add("filters__item");
            const input = document.createElement("input");
            input.setAttribute("type", "checkbox");
            input.setAttribute("id", `filter_${this.id}`);
            input.setAttribute("name", `filter_${this.id}`);
            input.setAttribute("value", `${this.id}`);
            input.classList.add("filters__checkbox");
            input.addEventListener("change", (() => {}));
            li.append(input);
            const label = document.createElement("label");
            label.setAttribute("for", `filter_${this.id}`);
            label.classList = "filters__label";
            li.append(label);
            const span = document.createElement("span");
            span.classList.add("filters__text");
            span.textContent = `${this.title}`;
            label.append(span);
            filtersCont.append(li);
        }
    }
    function clearContainer(selector) {
        const container = document.querySelector(selector);
        while (container.children.length > 0) container.firstChild.remove();
    }
    function renderPicture(object, selector) {
        const productImageDiv = document.createElement("div");
        if (object.srcset) {
            productImageDiv.classList = `${selector}__image-ibg`;
            const picture = document.createElement("picture");
            const source = document.createElement("source");
            const img = document.createElement("img");
            source.srcset = object.srcset;
            source.type = "image/webp";
            img.src = object.src;
            img.alt = object.title;
            img.loading = "lazy";
            picture.append(source);
            picture.append(img);
            productImageDiv.append(picture);
        } else {
            productImageDiv.classList = `${selector}__no-photo`;
            const img = document.createElement("img");
            img.src = "./img/icon-no-photo.svg";
            img.alt = object.name;
            productImageDiv.append(img);
        }
        return productImageDiv;
    }
    function renderPriceInfo(price, selector) {
        const divCardPrice = document.createElement("div");
        divCardPrice.classList = `${selector}__price`;
        const spanPriceValue = document.createElement("span");
        spanPriceValue.classList = `${selector}__price-value`;
        spanPriceValue.textContent = (+price).toFixed(2);
        divCardPrice.append(spanPriceValue);
        const spanPriceCurrency = document.createElement("span");
        spanPriceCurrency.classList = `${selector}__price-currency`;
        spanPriceCurrency.textContent = "грн.";
        divCardPrice.append(spanPriceCurrency);
        return divCardPrice;
    }
    class Product {
        constructor(product) {
            this.id = product.id;
            this.shopId = product.shop?.id;
            this.shopTitle = product.shop?.title;
            this.title = product.title;
            this.price = product.price.toFixed(2);
            this.src = product.photo?.src;
            this.srcset = product.photo?.srcset;
            this._renderProductCard();
        }
        _renderProductCard() {
            const filtersCont = document.querySelector(".products-list");
            const divProductCard = document.createElement("div");
            divProductCard.classList = "shop-main__product-card product-card";
            filtersCont.append(divProductCard);
            divProductCard.append(renderPicture(this, "product-card"));
            const divCardBody = document.createElement("div");
            divCardBody.classList = "product-card__body";
            divProductCard.append(divCardBody);
            const divCardInfo = document.createElement("div");
            divCardInfo.classList = "product-card__info";
            divCardBody.append(divCardInfo);
            const h4CardTitle = document.createElement("h4");
            h4CardTitle.classList = "product-card__title";
            h4CardTitle.textContent = `${this.title} (${this.shopTitle})`;
            divCardInfo.append(h4CardTitle);
            divCardInfo.append(renderPriceInfo(this.price, "product-card"));
            const buttonOrder = document.createElement("button");
            buttonOrder.classList = "product-card__order";
            buttonOrder.textContent = "Замовити";
            buttonOrder.addEventListener("click", (e => {
                this._addToCart();
            }));
            divCardBody.append(buttonOrder);
        }
        _addToCart() {
            const cartElement = document.querySelector(".header__cart");
            const product = {
                ...this,
                quantity: 1
            };
            if (localStorage.getItem("cart") === null) {
                localStorage.setItem("cart", JSON.stringify([ product ]));
                cartElement.textContent = 1;
            } else {
                const productsInCart = JSON.parse(localStorage.getItem("cart"));
                const isInCart = productsInCart.some((item => item.id === product.id));
                if (!isInCart) {
                    productsInCart.push(product);
                    localStorage.setItem("cart", JSON.stringify(productsInCart));
                    cartElement.textContent = productsInCart.length;
                }
            }
        }
    }
    function initShop() {
        const requestParams = {};
        getData("shops").then((data => {
            data.forEach((item => new Filter(item)));
        }));
        getData("foods").then((data => {
            data.forEach((item => new Product(item)));
        }));
        const checked = [];
        document.querySelector(".filters__list").addEventListener("change", (e => {
            if (!!e.target.closest(".filters__checkbox")) {
                let shopId = e.target.closest(".filters__checkbox").value;
                let i = checked.indexOf(shopId);
                if (i >= 0) checked.splice(i, 1); else checked.push(shopId);
                requestParams.shopIds = checked;
                if (checked.length === 0) delete requestParams.shopIds;
                clearContainer(".products-list");
                getData("foods", requestParams).then((data => {
                    data.forEach((item => new Product(item)));
                }));
            }
        }));
        if (localStorage.getItem("cart") !== null) {
            const productsInCart = JSON.parse(localStorage.getItem("cart"));
            document.querySelector(".header__cart").textContent = productsInCart.length;
        }
    }
    class Cart {
        constructor() {
            if (!this._storageSupported()) throw "Браузер не підтримує localStorage";
            if (!this._isEmpty()) this.products = JSON.parse(localStorage.getItem("cart")); else this.products = {};
        }
        remove(uniqueId) {
            const product_index = this._findIndexOf(uniqueId);
            if (product_index !== -1) {
                this.products.splice(product_index, 1);
                this._save();
            }
        }
        increaseQuantiti(uniqueId) {
            const product_index = this._findIndexOf(uniqueId);
            if (product_index !== -1) {
                this.products[product_index].quantity++;
                this._save();
            }
        }
        decreaseQuantity(uniqueId) {
            const product_index = this._findIndexOf(uniqueId);
            if (product_index !== -1) {
                if (this.products[product_index].quantity > 1) this.products[product_index].quantity--;
                this._save();
            }
        }
        getItemSum(uniqueId) {
            const product_index = this._findIndexOf(uniqueId);
            if (product_index !== -1) return this.products[product_index].quantity * this.products[product_index].price;
        }
        getTotalSum() {
            return this.products.reduce(((sum, product) => sum + product.quantity * product.price), 0);
        }
        clear() {
            localStorage.removeItem("cart");
        }
        _save() {
            localStorage.setItem("cart", JSON.stringify(this.products));
            if (this._isEmpty()) this.clear();
        }
        _findIndexOf(uniqueId) {
            let indexOf = -1;
            this.products.forEach(((product, index) => {
                if (product.id === uniqueId) indexOf = index;
            }));
            return indexOf;
        }
        _isEmpty() {
            return localStorage.getItem("cart") === null || JSON.parse(localStorage.getItem("cart")).length === 0;
        }
        _isIsset(id) {
            return this.products.some((item => item.id === id));
        }
        _storageSupported() {
            return typeof Storage !== "undefined" ? true : false;
        }
    }
    class FlashMessage {
        static get _CONSTANTS() {
            return {
                TYPES: {
                    SUCCESS: "success",
                    WARNING: "warning",
                    ERROR: "error",
                    INFO: "info"
                },
                CONTAINER: ".flash-messages",
                CLASSES: {
                    CONTAINER: "flash-messages",
                    MESSAGE: "flash-messages__message",
                    TEXT: "flash-messages__text",
                    CLOSE: "flash-messages__close",
                    FADEIN: "fadein",
                    FADEOUT: "fadeout"
                }
            };
        }
        constructor(message, type = FlashMessage._CONSTANTS.SUCCESS, container = FlashMessage._CONSTANTS.CONTAINER) {
            this._message = message;
            this._type = type;
            this._container = document.querySelector(container) || null;
            this._createContainer();
            this._createMessage();
        }
        static success(message) {
            return new FlashMessage(message, FlashMessage._CONSTANTS.TYPES.SUCCESS);
        }
        static warning(message) {
            return new FlashMessage(message, FlashMessage._CONSTANTS.TYPES.WARNING);
        }
        static error(message) {
            return new FlashMessage(message, FlashMessage._CONSTANTS.TYPES.ERROR);
        }
        static info(message) {
            return new FlashMessage(message, FlashMessage._CONSTANTS.TYPES.INFO);
        }
        _createContainer() {
            if (this._container === null) {
                this._container = document.createElement("div");
                this._container.classList.add(FlashMessage._CONSTANTS.CLASSES.CONTAINER);
                document.body.append(this._container);
            } else if (!this._container.classList.contains(FlashMessage._CONSTANTS.CLASSES.CONTAINER)) this._container.classList.add(FlashMessage._CONSTANTS.CLASSES.CONTAINER);
        }
        _createMessage() {
            this._messageElement = document.createElement("div");
            this._messageElement.classList.add(FlashMessage._CONSTANTS.CLASSES.MESSAGE, this._type);
            let messageText = document.createElement("div");
            messageText.classList.add(FlashMessage._CONSTANTS.CLASSES.TEXT);
            messageText.textContent = this._message;
            this._messageElement.append(messageText);
            let messageCloseBtn = document.createElement("button");
            messageCloseBtn.classList.add(FlashMessage._CONSTANTS.CLASSES.CLOSE);
            messageCloseBtn.addEventListener("click", (() => {
                this._stop();
            }));
            this._messageElement.append(messageCloseBtn);
            this._container.append(this._messageElement);
            this._behavior();
        }
        _behavior() {
            this._run();
            window.setTimeout((() => this._messageElement.classList.add(FlashMessage._CONSTANTS.CLASSES.FADEIN)), 0);
        }
        _run() {
            this._c_timeout = window.setTimeout((() => this._close()), 1e4);
        }
        _stop() {
            this._close();
            if (this._c_timeout !== null) {
                window.clearTimeout(this._c_timeout);
                this._c_timeout = null;
            }
        }
        _close() {
            this._messageElement.classList.remove(FlashMessage._CONSTANTS.CLASSES.FADEIN);
            this._messageElement.addEventListener("transitionend", (() => {
                this._container.removeChild(this._messageElement);
                this._clear();
            }));
        }
        _clear() {
            if (!this._container.children.length) this._container.parentNode.removeChild(this._container);
        }
    }
    function initCart() {
        const orderContainer = document.querySelector(".form-order__list");
        const totalSum = document.querySelector(".form-submit_sum-value");
        const cartIcon = document.querySelector(".header__cart");
        if (localStorage.getItem("cart") !== null) {
            const productsInCart = JSON.parse(localStorage.getItem("cart"));
            cartIcon.textContent = productsInCart.length;
        }
        const cart = new Cart;
        if (Object.keys(cart.products).length === 0) {
            orderContainer.textContent = "Корзина пуста";
            totalSum.textContent = (0).toFixed(2);
        } else for (const key in cart.products) {
            orderContainer.append(renderProduct(cart.products[key]));
            totalSum.textContent = cart.getTotalSum().toFixed(2);
        }
        orderContainer.addEventListener("click", (e => {
            const el = e.target;
            const cardClass = ".primary-card-gorizontal";
            const closestCard = el.closest(cardClass);
            const productId = +closestCard.dataset.productId;
            const priceValue = closestCard.querySelectorAll(cardClass + "__price-value")[1];
            if (el.closest(cardClass + "__remove-btn")) {
                cart.remove(productId);
                closestCard.remove();
                totalSum.textContent = cart.getTotalSum().toFixed(2);
                cartIcon.textContent = cartIcon.textContent - 1;
                if (orderContainer.childNodes.length === 0) {
                    orderContainer.textContent = "Корзина пуста";
                    cartIcon.textContent = "";
                }
            }
            if (el.closest(".quantity__button_plus")) {
                cart.increaseQuantiti(productId);
                priceValue.textContent = cart.getItemSum(productId).toFixed(2);
                totalSum.textContent = cart.getTotalSum().toFixed(2);
            }
            if (el.closest(".quantity__button_minus")) {
                cart.decreaseQuantity(productId);
                priceValue.textContent = cart.getItemSum(productId).toFixed(2);
                totalSum.textContent = cart.getTotalSum().toFixed(2);
            }
        }));
        document.addEventListener("formSent", (e => {
            if (Object.keys(cart.products).length !== 0) {
                const requestData = {
                    name: document.getElementById("name").value,
                    email: document.getElementById("email").value,
                    phone: document.getElementById("phone").value,
                    adress: document.getElementById("adress").value,
                    products: cart.products
                };
                cart.clear();
                orderContainer.textContent = "Корзина пуста";
                cartIcon.textContent = "";
                postData("order", requestData).then((() => {
                    FlashMessage.success("Замовлення відправлено!!!");
                }));
            }
        }));
    }
    function renderProduct(product) {
        const productCard = document.createElement("div");
        productCard.classList = "form-order__item primary-card-gorizontal";
        productCard.setAttribute("data-product-id", product.id);
        productCard.append(renderPicture(product, "primary-card-gorizontal"));
        const divBody = document.createElement("div");
        divBody.classList = "primary-card-gorizontal__body";
        productCard.append(divBody);
        const divInfo = document.createElement("div");
        divInfo.classList = "primary-card-gorizontal__info";
        divBody.append(divInfo);
        const h4Title = document.createElement("h4");
        h4Title.classList = "primary-card-gorizontal__title";
        h4Title.textContent = `${product.title} (${product.shopTitle})`;
        divInfo.append(h4Title);
        divInfo.append(renderPriceInfo(product.price, "primary-card-gorizontal"));
        const divBottom = document.createElement("div");
        divBottom.classList = "primary-card-gorizontal__bottom";
        divBody.append(divBottom);
        const divQuantity = document.createElement("div");
        divQuantity.classList = "primary-card-gorizontal__quantity quantity";
        divQuantity.setAttribute("data-quantity", "");
        divBottom.append(divQuantity);
        const buttonQuantityPlus = document.createElement("button");
        buttonQuantityPlus.classList = "quantity__button quantity__button_plus";
        buttonQuantityPlus.setAttribute("type", "button");
        buttonQuantityPlus.setAttribute("data-quantity-plus", "");
        divQuantity.append(buttonQuantityPlus);
        const divQuantityInput = document.createElement("div");
        divQuantityInput.classList = "quantity__input";
        divQuantity.append(divQuantityInput);
        const inputQuantity = document.createElement("input");
        inputQuantity.setAttribute("type", "text");
        inputQuantity.setAttribute("data-quantity-value", "");
        inputQuantity.setAttribute("autocomplete", "off");
        inputQuantity.setAttribute("disabled", "");
        inputQuantity.name = `form[quantity${product.id}]`;
        inputQuantity.value = product.quantity;
        divQuantityInput.append(inputQuantity);
        const buttonQuantityMinus = document.createElement("button");
        buttonQuantityMinus.setAttribute("type", "button");
        buttonQuantityMinus.classList = "quantity__button quantity__button_minus";
        buttonQuantityMinus.setAttribute("data-quantity-minus", "");
        divQuantity.append(buttonQuantityMinus);
        divBottom.append(renderPriceInfo(product.price * product.quantity, "primary-card-gorizontal"));
        const divRemove = document.createElement("div");
        divRemove.classList = "primary-card-gorizontal__remove";
        divBottom.append(divRemove);
        const buttonRemove = document.createElement("button");
        buttonRemove.setAttribute("type", "button");
        buttonRemove.classList = "primary-card-gorizontal__remove-btn";
        buttonRemove.textContent = "x";
        divRemove.append(buttonRemove);
        return productCard;
    }
    if (document.getElementById("shop-page")) initShop();
    if (document.getElementById("cart-page")) initCart();
    window["FLS"] = true;
    isWebp();
    menuInit();
    formFieldsInit({
        viewPass: false,
        autoHeight: false
    });
    formSubmit();
    formQuantity();
})();