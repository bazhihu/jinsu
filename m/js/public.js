$(document).ready(function(){
    var head_html="<script id='head_template' type='text/html'><table><tr><td>this is head</td></tr></table></script>";
    document.getElementById('head').innerHTML = head_html;

    var tongji = '<script>var _hmt = _hmt || [];(function() {var hm = document.createElement("script");hm.src = "//hm.baidu.com/hm.js?d4b3728eb406c2be15b33b492cc55362";var s = document.getElementsByTagName("script")[0];s.parentNode.insertBefore(hm, s);})(); </script>';
    var foot_html="<script id='foot_template' type='text/html'> <table ><tr><td>this is foot</td> </tr></table>"+tongji+"</script>";
    document.getElementById('foot').innerHTML = foot_html;
});