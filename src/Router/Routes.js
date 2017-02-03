import Home from '../Views/Home/Home'
import Page from '../Views/Page/Page'

const Routes = [
  {
    path: '/',
    component: Home,
    name: 'Home'
  },
  {
    path: '/:slug/',
    component: Page,
    name: 'Page'
  },
  {
    path: '/:slug/:childSlug/',
    component: Page,
    name: 'SubPage'
  }
]

export default Routes
