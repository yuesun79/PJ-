$('#like-button').click(function() {
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {
        }
    };
    xmlhttp.open("POST","../forPhp/like.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    alert($(this).children('input').attr('id'));
    xmlhttp.send("imageID="+$(this).children('input').attr('id'));

}


);


