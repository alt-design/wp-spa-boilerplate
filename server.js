/* ---------------------------------
 * Imports
 * --------------------------------- */
const http = require('http')
const express = require('express')
const app = express()
const axios = require('axios')
const webpackDevMiddleware = require('webpack-dev-middleware')

/* ---------------------------------
 * Options
 * --------------------------------- */
const options = {
  siteUrl: 'http://theme.dev/',
  portNumber: 8080
};

/* ---------------------------------
 * The server
 * --------------------------------- */
(function () {
  // Step 1: Create & configure a webpack compiler
  const webpack = require('webpack')
  const webpackConfig = require(process.env.WEBPACK_CONFIG ? process.env.WEBPACK_CONFIG : './webpack.config')
  const compiler = webpack(webpackConfig)

  // Step 2: Attach the dev middleware to the compiler & the server
  app.use(webpackDevMiddleware(compiler, {
    noInfo: true,
    quiet: true,
    publicPath: webpackConfig.output.publicPath,
    stats: {
      colors: true
    }
  }))

  // Step 3: Attach the hot middleware to the compiler & the server
  app.use(require('webpack-hot-middleware')(compiler))
})()

axios.get(options.siteUrl)

app.get('*', function (req, res) {
  res.sendFile(__dirname + '/webpackTemp.html')
})

const server = http.createServer(app)

server.listen(options.portNumber, () => {
  console.log('\r\nListening on port: ' + options.portNumber)
})

