const fs = require('fs')
const _ = require('lodash')

const ComponentGenerator = {

  dir: '',
  name: '',

  getNames(args){
    let returnItems = []
    for (let arg of args) if (!arg.includes('/')) returnItems.push(arg)
    return returnItems
  },

  createComponents(names){
    for (let name of names) this.createComponent(name)
  },

  createComponent(name){
    this.name = name
    this.dir = `./src/Components/${this.name}`

    this.createComponentDir()
    this.copyTemplates()
  },

  createComponentDir(){
    if (!fs.existsSync(this.dir)) fs.mkdirSync(this.dir, 0766)
  },

  copyTemplates(){
    const fileTypes = ['.vue', '.js', '.html', '.scss']

    for (let file of fileTypes) {
      this.copySyncFile(`./CLI/Templates/Component/Component${file}`, `${this.dir}/${this.name}${file}`)
      this.replaceText(`${this.dir}/${this.name}${file}`)
    }

    this.copySyncFile(`./CLI/Templates/Component/package.json`, `${this.dir}/package.json`)
    this.replaceText(`${this.dir}/package.json`)
  },

  replaceText(file){
    fs.readFile(file, 'utf8', (err, data) => {
      if (err) return console.log(err)
      let result = data
        .replace(/ComponentName/g, this.name)
        .replace(/component-name-kebab/g, _.kebabCase(this.name))

      fs.writeFile(file, result, 'utf8', function (err) {
        if (err) return console.log(err)
      })
    })
  },

  copySyncFile(src, dest){
    fs.writeFileSync(dest, fs.readFileSync(src))
  },

  init(){
    this.createComponents(this.getNames(process.argv))
  },

}

ComponentGenerator.init()