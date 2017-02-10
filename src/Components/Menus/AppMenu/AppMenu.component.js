/**
 * AppMenu
 *
 * @template : ./AppMenu.component.html
 * @style : ./AppMenu.component.scss
 */

const AppMenu = {
  props: {
    location: String,
    emitOnComplete: String,
  },
  data(){
    return {
      items: Object,
      fetched: false
    }
  },
  created(){
    this.$http.get('/wp-json/wp-api-menus/v2/menu-locations/' + this.location).then(res => {
      if (res.data.length > 0) {
        this.items = res.data
      } else {
        console.error('Failed to retrieve menu ' + this.location + ', check the menu location is correct and the menu is not empty.')
      }
    }).then(() => {
      this.fetched = true
    })
  },
  mounted(){
    let fetchInterval = setInterval(() => {
      if (this.fetched) {
        clearInterval(fetchInterval)
        this.emitOnComplete && this.$emit(this.emitOnComplete)
      }
    })
  },
}

export default AppMenu
