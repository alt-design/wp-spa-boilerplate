/**
 * Breadcrumbs
 *
 * @template : ./Breadcrumbs.component.html
 * @style : ./Breadcrumbs.component.scss
 */

const Breadcrumbs = {
  methods: {
    relativeLink(link){
      if (link) return link.replace(this.$store.state.url, '')
    }
  }
}

export default Breadcrumbs
