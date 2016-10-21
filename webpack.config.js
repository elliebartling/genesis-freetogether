var config = require('./gulpfile.js/config')
var debug = global.production !== true;
var webpack = require('webpack');
var BowerWebpackPlugin = require("bower-webpack-plugin");

var productionOnlyPlugins = [
  new webpack.optimize.DedupePlugin(),
  new webpack.optimize.OccurenceOrderPlugin(),
  new webpack.optimize.UglifyJsPlugin({ mangle: false, sourcemap: false })
]

var commonPlugins = [
  new BowerWebpackPlugin(),
  new webpack.ProvidePlugin({
      $: "jquery",
      jQuery: "jquery",
      "window.jQuery": "jquery"
  })
]

module.exports = {

  // Basic set up
  context: __dirname,
  entry: {
    freetogether: './src/javascripts/freetogether.js',
    discover: './src/javascripts/discover.js',
    lightboxes: './src/javascripts/lightboxes.js',
    admin: './src/javascripts/admin.js',
  },
  devtool: debug ? "source-map" : null,
  output: {
    path: __dirname + "/js",
    filename: "[name].js"
  },


  // Paths & Resolvers
  resolve: {
    modulesDirectories: ["web_modules", "node_modules", "components"],
    alias: {
      // 'owlcarousel': 'owl.carousel/owl-carousel/owl.carousel.js'
    }
  },

  // Modules & Plugins
  module: {
    loaders: [
      // Ignore styles, they're being processed by Gulp
      { test: /\.css$/, loader: 'ignore-loader' },
      { test: /\.scss$/, loader: 'ignore-loader' },
      { test: /\.less$/, loader: 'ignore-loader' },
      { test: /\.sass$/, loader: 'ignore-loader' },

      // Tell Bootstrap where Tether is
      { test: /tether\.js$/, loader: "expose?Tether" },
      { test: /\.coffee$/, loader: "coffee-loader" },
      // { test: /components\/.+\.(jsx|js)$/,
      //   loader: 'imports?jQuery=jquery,this=>window'
      // },

      // Use Babel to transpile custom js files
      {
        test: /\.js$/,
        exclude: /node_modules/,
        loader: 'babel-loader',
        query: {
          presets: ['es2015']
        }
      }
    ]
  },
  plugins: debug ? commonPlugins : commonPlugins.concat(productionOnlyPlugins)
};
