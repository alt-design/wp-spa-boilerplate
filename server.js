/* ---------------------------------
 * Imports
 * --------------------------------- */
const http = require('http')
const express = require('express')
const app = express()
const axios = require('axios')
const fs = require('fs')
const webpackDevMiddleware = require('webpack-dev-middleware')
let refreshCount = 0

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
  }))

  // Step 3: Attach the hot middleware to the compiler & the server
  app.use(require('webpack-hot-middleware')(compiler))
})()

function servingMessage () {
  console.log(`Webpack Dev Server @ Port ${options.portNumber}`)
  console.log(`Refreshed ${refreshCount} ${refreshCount > 1 ? 'times' : 'time'} at ${(new Date).toTimeString().slice(0, 8)}`)
  console.log('- - - -')
}

// Just to stop logging of favicon requests
app.get('/favicon.ico', () => {})

// Handle all other requests
app.get('*', (req, res) => {
  refreshCount = refreshCount + 1

  new Promise(resolve => {
    // Send the request to build webpackTemp.html
    axios.get(options.siteUrl)

    // Once webpackTemp.html has been updated, resolve the promise
    fs.watch(__dirname + '/webpackTemp.html', () => {
      setTimeout(() => { resolve() }, 250)
    })
  }).then(() => {
    // Server webpackTemp.html
    res.sendFile(__dirname + '/webpackTemp.html')
  }).then(() => {
    // Logging stuff
    servingMessage()
  })
})

// Init the server
http.createServer(app).listen(options.portNumber)

