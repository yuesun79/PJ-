function isNullInput(ele) {
    if (ele.value.length <= 0) return true;
}

$('#form2').on('submit', function(ev) {
    var verification = ['#content', '#country', '#city', '#title','description'].filter(function(id) {
        if (isNullInput($(id))) return true;
    }).length;

    if (!verification) return ev.preventDefault();
});