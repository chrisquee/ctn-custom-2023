const path = require('path');
var webpack = require('webpack');

// css extraction and minification
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

// clean out build dir in-between builds
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

module.exports = [
  {
    entry: {
      'main': [
        './assets/js/src/main.js',
        './assets/css/src/main.scss'
      ],
      'admin': './assets/js/admin/blocks.js',
    },
    output: {
      filename: './assets/js/[name].min.js',
      path: path.resolve(__dirname)
    },
    resolve: {
        alias: {
            jquery: "jquery/src/jquery"
        }
    },
    externals: {
		jquery: "jQuery",
	},
    module: {
      rules: [
        // js babelization
        {
          test: /\.(js|jsx)$/,
          exclude: /node_modules/,
          loader: 'babel-loader'
        },
        // sass compilation
        {
          test: /\.(sass|scss)$/,
          use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader']
        },
        // loader for webfonts (only required if loading custom fonts)
        {
          test: /\.(woff|woff2|eot|ttf|otf)$/,
          type: 'asset/resource',
          generator: {
            filename: './css/build/font/[name][ext]',
          }
        },
        // loader for images and icons (only required if css references image files)
        {
          test: /\.(png|jpg|gif)$/,
          type: 'asset/resource',
          dependency: { not: ['url'] },
          generator: {
            filename: './css/build/img/[name][ext]',
          }
        },
      ]
    },
    plugins: [
      // clear out build directories on each build
      new CleanWebpackPlugin({
        cleanOnceBeforeBuildPatterns: [
          './js/build/*',
          './css/build/*'
        ]
      }),
      new webpack.ProvidePlugin({
        $: "jquery",
        jQuery: "jquery",
        Popper: "popper.js",
      }),
      // css extraction into dedicated file
      new MiniCssExtractPlugin({
        filename: './assets/css/main.min.css'
      }),
    ],
    optimization: {
      // minification - only performed when mode = production
      minimizer: [
        // js minification - special syntax enabling webpack 5 default terser-webpack-plugin 
        `...`,
        // css minification
        new CssMinimizerPlugin(),
      ]
    },
  }
];