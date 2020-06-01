$(document).ready(function (e) {
    $(document).on("click", "#confirmDeleteIcon", function (e) {
        var slug = $(this).attr('data-value');
        document.getElementById("confirm").setAttribute("href", slug);
    });
});

$(document).ready(function () {
    $('.js-labels-multiple').select2({
        language: "it",
        placeholder: "Seleziona un'etichetta",
        allowClear: true,
    });
});

$(document).ready(function () {
    $('.js-interests-multiple').select2({
        language: "it",
        placeholder: "Seleziona un interesse",
        allowClear: true,
    });
});