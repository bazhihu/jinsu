(function(){
    $.extend($.fn, {
        // 应用程序启动时，只调用一次
        init: function () {
            // 获取Trigger推特更新内容
            forge.request.ajax({
                url: "http://api.youaiyihu.com/v1/configs",
                dataType: "json",
                success: showIndex
            });

            // 一旦我们有了Trigger推特更新内容，就调用
            function showIndex(data) {
                // 把初始数据保存起来
                Demo.items = new Demo.Collections.Items(data);
                // 建立Backbone
                Demo.router = new Demo.Router();
                Backbone.history.start();
            }
        }
    })
})(Zepto);