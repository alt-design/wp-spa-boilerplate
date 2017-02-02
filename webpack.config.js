const webpack = require('webpack');

// User Settings
const settings = {
  entry: [
    './src/main'
  ],
  output: {
    path: __dirname + '/dist/',
    publicPath: '/dist/',
    filename: 'bundle.js'
  }
};

// If add the webpack-hot-middleware client for hot reloading if necessary.
if (process.argv.indexOf('useDevMiddleware') > -1) settings.entry.unshift('webpack-hot-middleware/client');

// Webpack 2 Config
module.exports = {
  entry: settings.entry,
  output: settings.output,
  resolve: {
    extensions: ['.webpack.js', '.web.js', '.js', '.vue']
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
        loader: 'vue',
        options: {
          loaders: {
            scss: 'style!css!sass'
          }
        }
      },
      {
        test: /\.scss$/,
        loader: 'style!css!sass'
      },
      {
        test: /\.(jpe?g|png|gif|svg)$/i,
        loaders: [
          'file?hash=sha512&digest=hex&name=[hash].[ext]',
          'image-webpack?bypassOnDebug&optimizationLevel=7&interlaced=false'
        ]
      }
    ]
  },
  plugins: [
    new webpack.ProgressPlugin(),
    new webpack.optimize.OccurrenceOrderPlugin(),
    new webpack.HotModuleReplacementPlugin(),
    new webpack.NoErrorsPlugin()
  ]
};