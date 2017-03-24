import Http from 'axios'
import Functions from '../imports/Functions'

export default {

  setGlobalOptions (state, data) {
    state.global = data
  },

  setThemeDir (state, string) {
    state.theme = string
  },

  setSiteURL (state, string) {
    state.url = string
  },

  setAdminURL (state, string) {
    state.adminUrl = string
  },

  setName (state, name) {
    state.name = name
  },

  setTagLine (state, description) {
    state.tagLine = description
  },

  // This mutation is the life of the party
  updatePost (state, newPath) {
    Http.get(state.url + '/wp-json/alt/v1/all?slug=' + newPath).then(res => {
      state.post = res.data
      document.title = res.data.post_title + ' | ' + state.name

      Functions.updateAdminBar()
    }, res => {
      // Error
      console.error('Something went wrong with updatePost mutation, here it is:')
      console.error(res)
    })
  }
}
