$('#form').submit(function (e) {
    e.preventDefault();
    let data = new FormData(this);
    $.ajax({
        url:"../forPhp/forSearchPage.php",
        data:data,
        type:"post",
        cache:false,
        contentType:false,
        processData:false,
        success:function(res){
            $('#page').children("li[class!='arrows']").remove();
            $('#next').parent().before(res) ;
            $("#page").children("li").click(function (e) {
                e.preventDefault();
                let totalPage = $('#page').find('a').length - 2;
                alert(totalPage);
                let currentPage = $(this).children().data('page');
                if ($(this).children().attr('id')!=='prev' && $(this).children().attr('id')!=='prev') {
                    $('#prev').data('page', (currentPage > 1) ? currentPage - 1 : 1);
                    $('#next').data('page', (totalPage - currentPage) > 0 ? currentPage + 1 : currentPage);
                }


                let data = new FormData($('#form')[0]);
                data.append("page", $(this).children('a').data('page'));
                alert($(this).children('a').data('page'));
                $.ajax({
                    url: "../forPhp/forSearch.php",
                    data: data,
                    type: "post",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        document.getElementById("txtHint").innerHTML = res;
                        alert('pagething');
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

