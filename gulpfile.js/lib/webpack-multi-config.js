var config = require('../config')
if(!config.tasks.js) return

var path            = require('path')
var pathToUrl       = require('./pathToUrl')
var webpack         = require('webpack')
var webpackManifest = require('./webpackManifest')
var BowerWebpackPlugin = require("bower-webpack-plugin")

module.exports = function(env) {
  var jsSrc = path.resolve(config.root.src, config.tasks.js.src)
  var jsDest = path.resolve(config.root.dest, config.tasks.js.dest)
  var root = path.resolve(config.root.dest)
  // Explicitly declaring publicPath because gulp is running in a theme
  // subfolder, not at the root of the project
  // var publicPath = pathToUrl(config.tasks.js.dest, '/')
  var publicPath = 'themes/geeks-gulp/js'
  console.log("src: " + jsSrc);
  console.log("dest: " + jsDest);
  console.log("public: " + publicPath);
  console.log("root: " + root);

  var extensions = config.tasks.js.extensions.map(function(extension) {
    return '.' + extension
  })

  var rev = config.tasks.production.rev && env === 'production'
  var filenamePattern = rev ? '[name]-[hash].js' : '[name].js'

  var webpackConfig = {
    context: root,
    plugins: [
      new BowerWebpackPlugin({
        modulesDirectories: ["components"],
        manifestFiles:      "bower.json",
        includes:           /.js/,
        excludes:           [],
        searchResolveModulesDirectories: true
      }),
      new webpack.ProvidePlugin({
          $: "jquery",
          jQuery: "jquery",
          "window.jQuery": "jquery"
      })
    ],
    resolve: {
      root: [
        path.resolve(root,"node_modules"),
        path.resolve(root,"components"),
        jsSrc
      ],
      alias: [
        {  'isotope': 'isotope-layout' }
      ],
      extensions: [''].concat(extensions),
      modulesDirectories: ["web_modules", "node_modules"]
    },
    module: {
      loaders: [
        { test: /\.coffee$/, loader: "coffee-loader" },
        { test: /\.(coffee\.md|litcoffee)$/, loader: "coffee-loader?literate" },
        {
          test: /\.js$/,
          loader: 'babel-loader',
          exclude: /node_modules/,
          query: config.tasks.js.babel
        }
      ]
    },
    devtool: 'source-map'
  }

  if(env === 'development') {
    webpackConfig.devtool = 'inline-source-map'

    // Create new entries object with webpack-hot-middleware added
    for (var key in config.tasks.js.entries) {
      var entry = config.tasks.js.entries[key]
      config.tasks.js.entries[key] = ['webpack-hot-middleware/client?&reload=true'].concat(entry)
    }

    webpackConfig.plugins.push(new webpack.HotModuleReplacementPlugin())
  }

  if(env !== 'test') {
    // Karma doesn't need entry points or output settings
    webpackConfig.entry = config.tasks.js.entries
    console.log(path.normalize(jsDest));
    webpackConfig.output = {
      path: path.normalize(jsDest),
      filename: filenamePattern,
      publicPath: publicPath
    }

    if(config.tasks.js.extractSharedJs) {
      // Factor out common dependencies into a shared.js
      webpackConfig.plugins.push(
        new webpack.optimize.CommonsChunkPlugin({
          name: 'shared',
          filename: filenamePattern,
        })
      )
    }
  }

  if(env === 'production') {
    var publicPath = pathToUrl(config.tasks.js.dest, '/')
    if(rev) {
      webpackConfig.plugins.push(new webpackManifest(publicPath, config.root.dest))
    }
    webpackConfig.plugins.push(
      new webpack.DefinePlugin({
        'process.env': {
          'NODE_ENV': JSON.stringify('production')
        }
      }),
      new webpack.optimize.DedupePlugin(),
      new webpack.optimize.UglifyJsPlugin(),
      new webpack.NoErrorsPlugin()
    )
  }

  // return webpackConfig
}
