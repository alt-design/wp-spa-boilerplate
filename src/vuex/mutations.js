import Functions from '../imports/Functions';

export default {

    setThemeDir(state, string){
        state.theme = string;
    },

    setSiteURL(state, string){
        state.url = string;
    },

    setAdminURL(state, string){
        state.adminUrl = string;
    },

    setName(state, name){
        state.name = name;
    },

    setTagLine(state, description){
        state.tagLine = description;
    },

    // This mutation is the life of the party
    updatePage(state, newPath){

        Vue.$http.get('/wp-json/alt/v1/all?slug=' + newPath).then(res => {

            state.page     = res.data;
            document.title = res.data.post_title + " | " + state.name;

            Functions.updateAdminBar();

        }, res => {

            // Error
            console.error('Something went wrong with updatePage mutation, here it is:');
            console.error(res);

        });
    }
}
