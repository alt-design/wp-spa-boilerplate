const env = require('dotenv').config()
const webpack = require('webpack')

// User Settings
const settings = {
  entry: [
    'babel-polyfill', // Babel Polyfill is required by VueX for Promises in IE
    `./src/${env.parsed.ENTRY}`
  ],
  output: {
    JavaScript: {
      path: __dirname + '/dist/',
      publicPath: '/dist/',
      filename: env.parsed.OUTPUT
    }
  },
  scssLoaders: 'style-loader!css-loader!sass-loader!postcss-loader'
}

// If add the webpack-hot-middleware client for hot reloading if necessary.
process.argv.includes('useDevMiddleware') && settings.entry.unshift('webpack-hot-middleware/client')

// Webpack 2 Config
module.exports = {
  entry: settings.entry,
  output: settings.output.JavaScript,
  resolve: {
    extensions: ['.js', '.vue']
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        loader: 'babel-loader',
        exclude: /node_modules/
      },
      {
        test: /\.vue$/,
        loader: 'vue-loader',
        options: {
          loaders: {
            scss: settings.scssLoaders
          }
        }
      },
      {
        test: /\.scss$/,
        loader: settings.scssLoaders
      }
    ]
  },
  plugins: [
    new webpack.ProgressPlugin(),
    new webpack.optimize.OccurrenceOrderPlugin(),
    new webpack.HotModuleReplacementPlugin(),
    new webpack.NoEmitOnErrorsPlugin()
  ]
}
