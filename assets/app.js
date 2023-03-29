import './styles/app.scss';

import InfiniteAjaxScroll from '@webcreate/infinite-ajax-scroll';

let ias = new InfiniteAjaxScroll('#containerFeed', {
    item: '.content-preview',
    next: '.pager__next',
    pagination: '.pager',

    // false so we can bind manually after all images are loaded
    // -- if we didn't wait for images to load, the content would be
    // too short and IAS would try to load the next page right away
    bind: false
});

// manually hide the pagination because IAS isn't binded yet
document.querySelector('.pager').style.display = 'none';


ias.on('append', (event) => {
    let appendFn = event.appendFn;

    event.appendFn = (items, parent, last) => {
        return new Promise((resolve) => {
            appendFn(items, parent, last);

        });
    };
});
