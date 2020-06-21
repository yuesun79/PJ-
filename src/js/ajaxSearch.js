
$('#form').submit(function (e) {
    e.preventDefault();

    let data = new FormData(this);
    data.append("page",1);
    $.ajax({
        url:"../forPhp/forSearch.php",
        data:data,
        type:"post",
        // dataType:"json",//页面返回值的类型，共有三种：TEXT,JSON,XML可选
        cache:false,
        contentType:false,
        processData:false,
        success:function(res){
            document.getElementById("txtHint").innerHTML = res;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert(XMLHttpRequest.status);
            alert(XMLHttpRequest.readyState);
            alert(textStatus);
        }
    });
});