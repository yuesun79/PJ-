/*
上传预览
*/
//获取页面元素对象
let file = document.getElementById('file');
let output = document.getElementById('box');
file.onchange = function (e) {
    let files = e.target.files;
    let file0 = files[0];
    let fileReader = new FileReader();
    let type = 'default';
    if(/image/.test(file0.type)){
        fileReader.readAsDataURL(file0);
        type = 'image';
    } else {
        fileReader.readAsText(file0,'utf-8');
        type = 'text';
    }
    //文件加载出错
    fileReader.onerror = function () {
        output.innerHTML = 'Could not read file, error code is ' + fileReader.error.code;
    };
    //加载成功后
    fileReader.onload = function () {
        // console.log('onload');
        let html = '';
        switch (type) {
            case 'image':
                html = '<img src="' + fileReader.result +'">';
                break;
            case 'text':
                html = fileReader.result;
                break;
        }
        output.innerHTML = html;
    };
};
/*
ajax将图片保存到文件夹与数据库
 */
$('#form2').submit(function (e) {
    e.preventDefault();
    let data = new FormData(this);
    if (typeof($("#box").data("id")) !=="undefined") {
            data.append('ImageID',$('#box').data("id"));
    }

    $.ajax({
        url:"../forPhp/forUpload.php",
        data:data,
        type:"post",
        cache:false,
        contentType:false,
        processData:false,
        success:function(res){
            window.location.href = "../php/collections.php";

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("error");
            alert(XMLHttpRequest.status);
               alert(XMLHttpRequest.readyState);
               alert(textStatus);
        }
    });
});