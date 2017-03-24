/**
 * Breadcrumbs
 *
 * @template : ./Breadcrumbs.component.html
 * @style : ./Breadcrumbs.component.scss
 */

export default {
  methods: {
    relativeLink (link) {
      if (link) return link.replace(this.$store.state.url, '')
    }
  }
}
