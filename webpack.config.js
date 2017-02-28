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
  }
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
            scss: 'style-loader!css-loader!sass-loader!postcss-loader'
          }
        }
      },
      {
        test: /\.scss$/,
        loader: 'style-loader!css-loader!sass-loader!postcss-loader'
      },
      {
        test: /\.(jpe?g|png|gif|svg)$/i,
        loaders: [
          'file-loader?hash=sha512&digest=hex&name=[hash].[ext]',
          'image-webpack-loader?bypassOnDebug&optimizationLevel=7&interlaced=false'
        ]
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