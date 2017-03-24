![alt tag](https://raw.githubusercontent.com/alt-design/wp-spa-boilerplate/master/screenshot.jpg)

# WordPress Single Page Application Theme Boilerplate
##### A JavaScript SPA WordPress theme boilerplate using Vue and the WordPress REST API.


## Install
Install this theme just as you would install any modern theme boilerplate:

1. Navigate to your themes folder (usually /wp-content/themes/):
        
        cd /wp-content/themes/

2. Clone this repo:
    
        git clone https://github.com/alt-design/wp-spa-boilerplate NAME_OF_DIRECTORY

3. Enter the new folder (NAME_OF_DIRECTORY):

        cd NAME_OF_DIRECTORY
        
4. Install dependencies via npm or yarn:

        npm install 
    or
    
        yarn
        
## Running and Building

    npm run dev // starts a hot reload dev server (make sure to update your development URL in the .env file before running this)
    npm run watch // watches and compiles files to the dist folder, no hot reload though
    npm run build // compiles to the dist folder
    npm run production // optimises and compresses before compiling to the dist folder (this will disable Vue Devtools)
    
## VueX and Data Structure
All of your pages data is kept in a VueX store, by default the store will look like this:

    {
        adminUrl:"http://theme.dev/wp/wp-admin/"
        global:false // Global ACF Fields (Options Pages)
        theme:"http://theme.dev/app/themes/vue-theme"
        name:"Test"
        post:Object
            post_name:"sample-page"
            ID:2
            acf:false // ACF Fields
            breadcrumbs:Array[2]
                0:Object
                    permalink:"http://theme.dev/"
                    title:"Home"
                1:Object
                    permalink:"http://theme.dev/sample-page/"
                    title:"Sample Page"
            featured_image:null
            post_content:"This is an example page..."
            post_date:"2017-03-24 12:26:39"
            post_excerpt:""
            post_parent:0
            post_title:"Sample Page"
            post_type:"page"
        url:"http://theme.dev"
    } 

## Components

### Menu
The menu component is used to retrieve & display WordPress menus:

    <app-menu location="main" emit-on-complete="mainMenuLoaded"></app-menu>
    
##### Props

- location : string (required) - the menu's registered theme location
- emitOnComplete : string (optional) - an optional Vue.$emit to be called after the menu is loaded
 
 
### Breadcrumbs
The breadcrumb component is used to retrieve & display breadcrumbs for the current path:

    <breadcrumbs></breadcrumbs>

