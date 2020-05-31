$(document).ready(function (e) {
    $(document).on("click", "#confirmDeleteIcon", function (e) {
        var slug = $(this).attr('data-value');
        document.getElementById("confirm").setAttribute("href", slug);
    });
});
