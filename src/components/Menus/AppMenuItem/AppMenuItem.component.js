/**
 * AppMenuItem
 *
 * @template : ./AppMenuItem.component.html
 * @style : ./AppMenuItem.component.scss
 */

export default {
  props: {
    item: Object,
    location: String,
    depth: {
      type: Number,
      default: 0
    }
  },
  methods: {
    getSlug (string) {
      return string.replace(this.$store.state.url, '', string)
    }
  }
}
