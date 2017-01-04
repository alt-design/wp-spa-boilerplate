import Home from '../views/Home/Home.vue';
import Page from '../views/Page/Page.vue';

const routes = [
    {
        path     : '/',
        component: Home,
        name     : 'Home'
    },
    {
        path     : '/:slug/',
        component: Page,
        name     : 'Page'
    },
    {
        path     : '/:slug/:childSlug/',
        component: Page,
        name     : 'SubPage'
    }
];

export default routes