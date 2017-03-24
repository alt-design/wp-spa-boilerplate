module.exports = {
  syntax: require('postcss-scss'),
  plugins: [
    require('autoprefixer'),
    require('css-mqpacker')
  ]
}
