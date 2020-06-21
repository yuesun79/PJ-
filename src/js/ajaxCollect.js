$(document).ready(function () {
    let data1 = new FormData();
    data1.append("page", 1);
    $.ajax({
        url: "../forPhp/forCollection.php",
        data: data1,
        type: "post",
        cache: false,
        contentType: false,
        processData: false,
        success: function (res) {
            document.getElementById("txtHint").innerHTML = res;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("error");
            alert(XMLHttpRequest.status);
            alert(XMLHttpRequest.readyState);
            alert(textStatus);
        }
    });
    let data2 = new FormData();
    $.ajax({
        url:"../forPhp/forCollectPage.php",
        type:"post",
        data:data2,
        cache:false,
        contentType:false,
        processData:false,
        success:function(res){

            $('#page').children("li[class!='arrows']").remove();
            $('#next').parent().before(res) ;
            $("#page").children("li").click(function (e) {
                e.preventDefault();
                let totalPage = $('#page').find('a').length - 2;
                let currentPage = $(this).children().data('page');
                if ($(this).children().attr('id')!=='prev' && $(this).children().attr('id')!=='prev') {
                    $('#prev').data('page', (currentPage > 1) ? currentPage - 1 : 1);
                    $('#next').data('page', (totalPage - currentPage) > 0 ? currentPage + 1 : currentPage);
                }

                let data = new FormData();
                data.append("page", $(this).children('a').data('page'));
                $.ajax({
                    url: "../forPhp/forCollection.php",
                    data: data,
                    type: "post",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        document.getElementById("txtHint").innerHTML = res;
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("error");
                        alert(XMLHttpRequest.status);
                        alert(XMLHttpRequest.readyState);
                        alert(textStatus);
                    }
                })
            });
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("error");
            alert(XMLHttpRequest.status);
            alert(XMLHttpRequest.readyState);
            alert(textStatus);
        }
    });
});
