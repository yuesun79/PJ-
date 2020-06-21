$("#user").focus(function () {
        this.setAttribute("placeholder", "用户名为四位以上的字母、数字、符号组合,符号仅包含_.");
    }).blur(function () {
    if (!$("#user").val()) {
        //输入框没有输入任何值的情况下，恢复默认状态
        this.setAttribute("placeholder", "用户名");
    }
});
$('#password_again').keyup(
function ckPassword() {
    let password = $("#password").val();
    let repassword = $("#password_again").val();
    let tip = $("#tip");
    if(password === repassword) {
        tip.innerHTML="";
        $("#submit").removeAttr("disabled");

    }else {
        tip.innerHTML="两次密码输入不一致";
        tip.css("color","orange");
        $("#submit").setAttribute("disabled","disabled");
    }
});
// jQuery.validator.setDefaults({
//     debug: true,
//     success: "valid"
// });
// $( "#form" ).validate({
//     rules: {
//         password: "required",
//         password_again: {
//             equalTo: "#password"
//         }
//     }
// });
function ckName() {
    let user = $('#user');
    let value  = user.val();
    let pattern = /^([a-zA-Z]\d_.){4,}$/;
    if (value === '') {
        user.setAttribute('placeholder',"用户名不能为空");
        return false;
    }
    else if (!pattern.test(value)) {
        user.setAttribute('placeholder',"用户名不符合规范");
        return false;
    }
    else return true;
}

function ckEmail() {
 let email = $('#email');
 let value = email.val();
 let pattern = /^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/;
    if (value === '') {
        user.setAttribute('placeholder',"邮箱不能为空");
        return false;
    }
    else if (!pattern.test(value)) {
        user.setAttribute('placeholder',"邮箱不符合规范");
        return false;
    }
    else return true;
}

