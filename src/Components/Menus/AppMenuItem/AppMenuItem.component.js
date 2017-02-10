/**
 * AppMenuItem
 *
 * @template : ./AppMenuItem.component.html
 * @style : ./AppMenuItem.component.scss
 */

const AppMenuItem = {
  props: {
    item: Object,
    location: String,
    depth: {type: Number, default: 0}
  },
  methods: {
    getSlug(string){
      return string.replace(this.$store.state.url, '', string)
    }
  }
}

export default AppMenuItem
