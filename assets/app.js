import './styles/app.scss';
import './js/notyf.js';
document.querySelectorAll('.search-select').forEach(function (select) {
    select.addEventListener('change', function () {
        console.log(document.getElementsByName('search')[0].value);
        if (select.classList.contains('get-search')) {
            document.getElementById('fake-search').value = document.getElementsByName('search')[0].value;
        }
        select.closest('form').submit();
    });
});
// import if you use the NPM package (not needed if you use CDN)
import InfiniteAjaxScroll from '@webcreate/infinite-ajax-scroll';

let ias = new InfiniteAjaxScroll('.containerFeed', {
    item: '.content-preview',
    next: '.next',
    pagination: '.pager'
});