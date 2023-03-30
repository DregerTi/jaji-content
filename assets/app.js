import './styles/app.scss';
import './js/notyf.js';
// import if you use the NPM package (not needed if you use CDN)
import InfiniteAjaxScroll from '@webcreate/infinite-ajax-scroll';

let ias = new InfiniteAjaxScroll('.containerFeed', {
    item: '.content-preview',
    next: '.next',
    pagination: '.pager'
});