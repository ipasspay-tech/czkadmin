<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en-gb" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>czkadmin</title>
    <!--<link rel="stylesheet" href="//cdn.bootcss.com/uikit/2.25.0/css/uikit.css" />-->
    <!--<script src="//cdn.bootcss.com/uikit/2.25.0/js/uikit.js"></script>-->
    <link rel="stylesheet" href="/czkadmin/Public/uikit-2.25.0/css/uikit.min.css" />
    <link rel="stylesheet" href="/czkadmin/Public/css/jquery.json-viewer.css" />
    <link rel="stylesheet" href="/czkadmin/Public/css/loading.css" />
    <script src="/czkadmin/Public/uikit-2.25.0/js/uikit.js"></script>
    <script src="/czkadmin/Public/jquery/jquery-3.1.1.min.js"></script>
    <script src="/czkadmin/Public/jquery/jquery.json-viewer.js"></script>

</head>


<body>
<div class="uk-container uk-container-center uk-margin-top uk-margin-large-bottom">

    <nav class="uk-navbar uk-margin-large-bottom">
        <a class="uk-navbar-brand uk-hidden-small" href="<?php echo U('Home/Index/index');?>">首页</a>
        <a class="uk-navbar-brand uk-hidden-small" href="http://ai.baidu.com/docs/#/OCR-API/top" target="_blank">开发文档</a>
        <!--<a class="uk-navbar-brand uk-hidden-small" href="#">返回首页</a>-->
        <!--<a class="uk-navbar-brand uk-hidden-small" href="#">sample4</a>-->
        <!--<a class="uk-navbar-brand uk-hidden-small" href="#">sample5</a>-->
        <!--<a class="uk-navbar-brand uk-hidden-small" href="#">sample6</a>-->
    </nav>

    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="uk-grid">
                <div class="uk-width-1-6">
                    <i class="uk-icon-file-photo-o uk-icon-large uk-text-primary"></i>
                </div>
                <div class="uk-width-5-6">
                    <h2 class="uk-h3">人脸检测</h2>
                    <p>请上传人脸图像</p>
                    <input type="file" name="face_pic" id="face_pic" accept="image/gif/jpg" onchange="facePreview()"/>
                    <img id="face_pic_show" name="face_pic_show" src="" style="width: 100px; height: 100px" />
                    <input type="button" name="uploadPicButton" value="上传" onclick="facePic()" />
                    <div class="uk-grid" data-uk-grid-margin >
                        <div class="uk-width-medium-1-1">
                            <pre id="facePre"><p>返回结果</p></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="uk-grid">
                <div class="uk-width-1-6">
                    <i class="uk-icon-tree uk-icon-large uk-text-primary"></i>
                </div>
                <div class="uk-width-5-6">
                    <h2 class="uk-h3">人脸比对</h2>
                    <p>请上传两张人脸图片</p>
                    <input type="file" name="match1_pic" id="match1_pic" accept="image/gif/jpg" onchange="match1Preview()" />
                    <img id="match1_pic_show" name="match1_pic_show" src="" style="width: 100px; height: 100px" />
                    <input type="file" name="match2_pic" id="match2_pic" accept="image/gif/jpg" onchange="match2Preview()" />
                    <img id="match2_pic_show" name="match2_pic_show" src="" style="width: 100px; height: 100px" />
                    <br>
                    <input type="button" name="uploadPicButton" value="上传" onclick="matchPic()" />
                    <div class="uk-grid" data-uk-grid-margin >
                        <div class="uk-width-medium-1-1">
                            <pre id="matchPre"><p>返回结果</p></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="uk-grid">
                <div class="uk-width-1-6">
                    <i class="uk-icon-github-alt uk-icon-large uk-text-primary"></i>
                </div>
                <div class="uk-width-5-6">
                    <h2 class="uk-h3">在线活体检测</h2>
                    <p>请上传需要检测的图片(faceliveness:活体判断，活体检测接口主要用于判断是否为二次翻拍)</p>
                    <input type="file" name="faceverify_pic" id="faceverify_pic" accept="image/gif/jpg" onchange="faceverifyPreview()"/>
                    <img id="faceverify_pic_show" name="faceverify_pic_show" src="" style="width: 100px; height: 100px" />
                    <input type="button" name="uploadPicButton" value="上传" onclick="faceverifyPic()" />
                    <div class="uk-grid" data-uk-grid-margin >
                        <div class="uk-width-medium-1-1">
                            <pre id="faceverifyPre"><p>返回结果</p></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<!--loading动画!-->
<div id="loading" class="loading" style="display:none">Loading pages...</div>

</body>
</html>

<script>

    // 人脸检测
    function facePic() {
        var pic = $('#face_pic')[0].files[0];
        var fd = new FormData();
        $('#loading').show();
        fd.append('face_pic', pic);
        $.ajax({
            url:"<?php echo U('facedetect/faceDetectApi');?>",
            type:"post",
            // Form数据
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            success:function(data){
                $('#loading').hide();

                try {
                    var input = eval('(' + data + ')');
                }
                catch (error) {
                    return alert("Cannot eval JSON: " + error);
                }
                var options = {
                    collapsed: false,
                    withQuotes: false
                };
                $('#facePre').jsonViewer(input, options);
            }
        });

    }
    // 人脸比对
    function matchPic() {
    var pic1 = $('#match1_pic')[0].files[0];
    var pic2 = $('#match2_pic')[0].files[0];
    var fd = new FormData();
    $('#loading').show();
    fd.append('match1_pic', pic1);
    fd.append('match2_pic', pic2);
    $.ajax({
        url:"<?php echo U('facedetect/matchDetectApi');?>",
        type:"post",
        // Form数据
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        success:function(data){
            $('#loading').hide();

            try {
                var input = eval('(' + data + ')');
            }
            catch (error) {
                return alert("Cannot eval JSON: " + error);
            }
            var options = {
                collapsed: false,
                withQuotes: false
            };
            $('#matchPre').jsonViewer(input, options);
        }
    });

}
    // 活体检测
    function faceverifyPic() {
        var pic = $('#faceverify_pic')[0].files[0];
        var fd = new FormData();
        $('#loading').show();
        fd.append('faceverify_pic', pic);
        $.ajax({
            url:"<?php echo U('facedetect/faceverifyDetectApi');?>",
            type:"post",
            // Form数据
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            success:function(data){
                $('#loading').hide();

                try {
                    var input = eval('(' + data + ')');
                }
                catch (error) {
                    return alert("Cannot eval JSON: " + error);
                }
                var options = {
                    collapsed: false,
                    withQuotes: false
                };
                $('#faceverifyPre').jsonViewer(input, options);
            }
        });

    }


    // 显示人脸检测图片
    function facePreview() {
        var r= new FileReader();
        f=document.getElementById('face_pic').files[0];

        r.readAsDataURL(f);
        r.onload=function (e) {
            document.getElementById('face_pic_show').src=this.result;
        };
    }
    // 显示人脸比对图片1
    function match1Preview() {
        var r= new FileReader();
        f=document.getElementById('match1_pic').files[0];

        r.readAsDataURL(f);
        r.onload=function (e) {
            document.getElementById('match1_pic_show').src=this.result;
        };
    }
    // 显示人脸比对图片2
    function match2Preview() {
        var r= new FileReader();
        f=document.getElementById('match2_pic').files[0];

        r.readAsDataURL(f);
        r.onload=function (e) {
            document.getElementById('match2_pic_show').src=this.result;
        };
    }
    // 显示活体检测图片
    function faceverifyPreview() {
        var r= new FileReader();
        f=document.getElementById('faceverify_pic').files[0];

        r.readAsDataURL(f);
        r.onload=function (e) {
            document.getElementById('faceverify_pic_show').src=this.result;
        };
    }



</script>


</script>