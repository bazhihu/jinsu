$('.download').on(CLICK,function(){
    var ifrSrc="yayhapp://cn.md.dt/";//APP协议头，由APP开发人员定义提供
    if(navigator.userAgent.toLowerCase().match(/(iphone|ipad|ipod|ios)/i)){
        document.location ="downloadIos.html";
//                //IOS
//                var hasApp = true;//是否安装了app
//                var t1 = Date.now();
//                var ifr = document.createElement('iframe');
//                ifr.src = ifrSrc ;
//                ifr.style.display = 'none';
//                document.body.appendChild(ifr);
//                setTimeout(function(){
//                    document.body.removeChild(ifr);
//                },1000);
//                var t2 = Date.now();
//                if(t2-t1<100){
//                    hasApp = false;
//                }
//                if(!hasApp){//如果没安装，再打开下载地址
//                    document.location = "跳转到appstore地址";
//                }
    }else if(navigator.userAgent.toLowerCase().match(/MicroMessenger/i)=="micromessenger") {
        //微信
        $('#weixin').show();
        $('#down').hide();
    }else if(navigator.userAgent.toLowerCase().match(/linux/i)){
        //安卓
        if(navigator.userAgent.toLowerCase().match(/android/i)){
            var openAppHref=document.createElement('a');
            openAppHref.id="openApp";
            openAppHref.href='javascript:void(0)';
            openAppHref.style.display = 'none';
            document.body.appendChild(openAppHref);

            document.getElementById('openApp').onclick = function(e){
                var ifr = document.createElement('iframe');
                ifr.src = ifrSrc ;
                ifr.style.display = 'none';
                document.body.appendChild(ifr);
                setTimeout(function(){
                    document.body.removeChild(ifr);
                },1000);
            };

            var e = document.createEvent("MouseEvents");
            e.initEvent("click", true, true);
            document.getElementById("openApp").dispatchEvent(e);
            location.href = "http://download.youaiyihu.com/youaiyihu-android-release.apk";
        }
    }else{
        location.href ="http://download.youaiyihu.com/youaiyihu-android-release.apk";
    }
});