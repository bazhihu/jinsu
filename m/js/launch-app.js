; ~function () {
    var bar = document.getElementById('launch-app'), close, button;
    if (bar) {
        close = bar.querySelector('.close');
        button = bar.querySelector('.launch-app-button');
        $(close).tap(function () {
            document.body.style.pointerEvents = 'none';
            $(bar).addClass('closed');
            setTimeout(function () {
                document.body.style.pointerEvents = '';
                document.body.style.removeProperty('pointerEvents');
            }, 500);
        });



        var nA = navigator.userAgent,
            ios = /iPhone|iPad|iPod|iTouch/i.test(nA),
            webkit = /webkit/i.test(nA),
            android = /android/i.test(nA) || (webkit && !ios),
            platform = ios ? 'iphone' : (android ? 'android' : 'windows'),
            wechat = /MicroMessenger/i.test(nA);

        var openFrame = document.createElement('iframe'), openTimeout;
        openFrame.setAttribute('width', 0);
        openFrame.setAttribute('height', 0);
        openFrame.setAttribute('style', 'display:none;overflow:hidden;');
        document.body.appendChild(openFrame);

        button.addEventListener('click', function (e) {
            var href = this.href;
            if (wechat) {
                var tips = document.querySelector('.wechat-download-tips');
                if (!tips) {
                    tips = document.createElement('div');
                    tips.className = 'wechat-download-tips';
                    tips.addEventListener('touchstart', function () {
                        this.touchstart = 1;
                    });
                    tips.addEventListener('touchmove', function (e) {
                        e.preventDefault();
                    });
                    tips.addEventListener('touchend', function () {
                        if (this.touchstart) {
                            this.style.opacity = 0;
                            setTimeout(function () {
                                tips.style.display = 'none';
                            }, 400);
                        }
                    });
                    document.addEventListener('touchmove', function () {
                        tips.touchstart = 0;
                    });
                    document.addEventListener('touchcancel', function () {
                        tips.touchstart = 0;
                    });
                    tips.innerHTML = '<span>\u5728' + (/iPhone|iPad|iPod|iTouch/i.test(window.navigator.userAgent) ? ' Safari ' : '\u6d4f\u89c8\u5668') + '\u4e2d\u6253\u5f00</span>';
                    document.body.appendChild(tips);
                }
                setTimeout(function () {
                    tips.style.display = 'block';
                    setTimeout(function () {
                        tips.style.opacity = 1;
                    }, 0);
                }, 1000);
            }

            var apk = this.getAttribute('data-apk');
            var appstore = this.getAttribute('data-appstore');
            var wp = this.getAttribute('data-wp');
            var myapp = this.getAttribute('data-myapp');

            e.preventDefault();
            openTimeout = setTimeout(function () {
                var url;
                if (wechat) {
                    if (myapp) {
                        url = myapp;
                    }
                } else if (ios) {
                    if (appstore) {
                        url = appstore;
                    }
                } else if (android) {
                    if (apk) {
                        url = apk;
                    }
                }

                if (url) {
                    location.href = url;
                }
            }, 500);

            openFrame.setAttribute('src', href);
        });
    }
}();