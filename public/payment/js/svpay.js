(function () {
    var defaults = {
        api_token: ""
    };

    var domain = "https://payment.tspu.edu.ru";

    var options = {};

    this.PAYConstructor = function () {
        if (arguments[0] && typeof arguments[0] === 'object') {
            options = extendDefaults(defaults, arguments[0]);
        }

        function extendDefaults(source, properties) {
            var property;
            for (property in properties) {
                // eslint-disable-next-line no-prototype-builtins
                if (Object.prototype.hasOwnProperty.call(properties, property)) {
                    source[property] = properties[property];
                }
            }
            return source;
        }
    };

    this.payCheckout = function (data) {
        window.addEventListener('message', gotEvent);

        function createIframe(order) {
            // Create iframe
            var iframe = document.createElement('iframe'),
                iframeStyle = iframe.style,
                orderStr = JSON.stringify(order),
                scrollTop = window.pageYOffset + 'px';

            iframeStyle.position = 'absolute';
            iframeStyle.top = '0px';
            iframeStyle.right = '0px';
            iframeStyle.bottom = '0px';
            iframeStyle.left = '0px';
            iframeStyle.width = '100%';
            iframeStyle.height = '100%';
            iframeStyle.minHeight = '100vh';
            iframeStyle.border = '0';
            iframeStyle.zIndex = '10000';
            iframe.id = options.api_token;
            iframe.src = domain + '/payform?token=' + options.api_token + '&product=' + data.product + '&modal=true&order=' + encodeURIComponent(orderStr);

            iframe.setAttribute('allowfullscreen', '');
            iframe.setAttribute('data-offset', scrollTop);

            // Create styles for #ScrollWrapper and iframe
            var style = document.createElement('style');
            style.innerHTML =
                '\
                html, body {\
                  -webkit-overflow-scrolling: touch !important;\
                }\
                #iframeScrollWrapper {\
                  position: fixed;\
                  right: 0; \
                  bottom: 0; \
                  left: 0;\
                  top: 0;\
                  -webkit-overflow-scrolling: touch !important;\
                  overflow-y: auto !important;\
                  overflow-x: hidden;\
                  z-index: 9999;\
                  background-color: #f5f5f5;\
                }\
                ';

            // Create a layer for the iframe #ScrollWrapper
            var scrollWrapper = document.createElement('div');
            scrollWrapper.id = 'iframeScrollWrapper';

            // Adding code to the page
            scrollWrapper.appendChild(style);
            scrollWrapper.appendChild(iframe);
            document.body.insertBefore(scrollWrapper, document.body.firstChild);

            // Hack for android-chrome render bug
            var isAndroid = /(android)/i.test(navigator.userAgent);
            if (isAndroid) {
                iframe.addEventListener('load', function () {
                    setTimeout(function () {
                        iframe.style.display = "none";
                        setTimeout(function () {
                            iframe.style.display = "block";
                        }, 0);
                    }, 0);
                });
            }

            return iframe;

        }

        createIframe({});

        var iframe = document.querySelector('iframe');

        function gotEvent(e) {
            var data = e.data;

            // Fix chrome bug
            if (typeof e.data === 'string') {
                data = JSON.parse(e.data);
            }
            if (!('type' in data)) {
                return;
            }

            switch (data.type) {
                case 'CLOSE':
                    window.removeEventListener('message', gotEvent);
                    break;

                default:
                    console.warn('Incorrect iframe message');
            }
        }

        window.addEventListener('message', closeModal);

        function closeModal(e) {
            var data = e.data;
            if (typeof e.data === 'string') {
                data = JSON.parse(e.data);
            }
            if (!('type' in data)) {
                return;
            }
            if (data.type === 'CLOSE') {
                var scrollWrapper = document.getElementById('iframeScrollWrapper');

                document.body.removeChild(scrollWrapper);
                document.body.getAttribute('style');
                document.body.removeAttribute('style');
                window.removeEventListener('message', closeModal);
            }
        }
    };
    // var pay = new PAYConstructor({api_token:123});
})();


