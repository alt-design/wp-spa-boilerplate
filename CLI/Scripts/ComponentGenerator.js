const fs = require('fs')
const _ = require('lodash')

const ComponentGenerator = {

  buildItems(args){
    let returnItems = args.splice(2, Infinity)

    for (let [index, currentItem] of returnItems.entries()) {

      // Makes array from file path, e.g. '1/2/3' -> [1,2,3]
      let itemSplit = currentItem.split('/')

      returnItems[index] = {
        // Adds the last array item of itemSplit (the name of the component to be generated)
        'name': itemSplit[itemSplit.length - 1],

        // Adds all the itemSplit array items which are not last (the parent directory/ies)
        'path': './src/Components/' + itemSplit.join('/') || ''
      }

      // Creates all of the folders
      this.generateDirectories(itemSplit)
    }

    return returnItems // Returns the modified array of items and their parent directories
  },

  generateDirectories(items){
    let tempDir = './src/Components'
    for (let folder of items) this.createDir(tempDir += '/' + folder)
    console.log(`> Component Directory Generated @ ${tempDir}`)
  },

  createDir(newDir = false){
    if (!fs.existsSync(newDir)) fs.mkdirSync(newDir, 0766)
  },

  createComponents(names){
    for (let name of names) {
      this.copyTemplates(name['path'], name['name'])
    }
  },

  copyTemplates(dir, name){

    console.log('-------------------------')
    console.log('Creating Files')
    console.log('-------------------------')

    const fileTypes = ['.component.vue', '.component.js', '.component.html', '.component.scss']

    for (let file of fileTypes) {
      this.copySyncFile(`./CLI/Templates/Component/Component${file}`, `${dir}/${name}${file}`)
      this.replaceText(`${dir}/${name}${file}`, name)

      console.log(`> File "${dir}/${name}${file}" created`)
    }

    this.copySyncFile(`./CLI/Templates/Component/package.json`, `${dir}/package.json`)
    this.replaceText(`${dir}/package.json`, name)
    console.log(`> File "${dir}/package.json" created`)

  },

  replaceText(file, name){
    fs.readFile(file, 'utf8', (err, data) => {
      if (err) return console.log(err)
      let result = data
        .replace(/ComponentName/g, name)
        .replace(/component-name-kebab/g, _.kebabCase(name))

      fs.writeFile(file, result, 'utf8', function (err) {
        if (err) return console.log(err)
      })
    })
  },

  copySyncFile(src, dest){
    fs.writeFileSync(dest, fs.readFileSync(src))
  },

  init(){
    console.log('> Component Generator Intitiated')
    this.createComponents(this.buildItems(process.argv))
  },

}

ComponentGenerator.init()