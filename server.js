/**
 * Imports
 */
const env = require('dotenv').config()
const http = require('http')
const express = require('express')
const app = express()
const axios = require('axios')
const fs = require('fs')
const webpackDevMiddleware = require('webpack-dev-middleware')
const webpack = require('webpack')
const webpackConfig = require(process.env.WEBPACK_CONFIG ? process.env.WEBPACK_CONFIG : './webpack.config')
const compiler = webpack(webpackConfig)

/**
 * Server Plugins
 */
app.use(webpackDevMiddleware(compiler, {noInfo: true, quiet: true, publicPath: webpackConfig.output.publicPath}))
app.use(require('webpack-hot-middleware')(compiler))

/**
 * Routes
 */
// Just to stop logging of favicon requests
app.get('/favicon.ico', () => {})

// Handle all other requests
app.get('*', (req, res) => {
  new Promise(resolve => {
    // Send the request to build webpackTemp.html
    axios.get(env.parsed.DEV_URL)

    // Once webpackTemp.html has been updated, resolve the promise
    fs.watch(__dirname + '/webpackTemp.html', () => {
      setTimeout(() => { resolve() }, 250)
    })
  }).then(() => {
    // Server webpackTemp.html
    res.sendFile(__dirname + '/webpackTemp.html')
  })
})

/**
 * Initiate the server
 */
http.createServer(app).listen(env.parsed.PORT)
