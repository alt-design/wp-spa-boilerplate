import Page from '../Components/Views/Page'

const Routes = [
  {
    path: '/',
    component: Page,
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