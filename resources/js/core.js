$('select').select2({
    minimumResultsForSearch: Infinity
});

$('.my-btn-search').on('click', function() {
    $('.my_search').css('display', 'block');
    $('.my_search input').focus();
});

$('.my_search input').on('blur', function() {
    $('.my_search').css('display', 'none');
});