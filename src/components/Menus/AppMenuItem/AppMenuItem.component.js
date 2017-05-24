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
  }
}
