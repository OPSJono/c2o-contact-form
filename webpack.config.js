const path = require('path');
const webpack = require('webpack'); //to access built-in plugins
const MiniCssExtractPlugin  = require("mini-css-extract-plugin");

(function () {
    'use strict';
}());

module.exports = {
    watch: true,
    entry: './assets/js/index.js',
    output: {
        filename: 'js/index.js',
        path: path.resolve(__dirname, 'public')
    },
    module: {
        rules: [
            {
                test: /\.less$/,
                exclude: ['/node_modules/', '/public/'],
                loader: 'less-loader', // compiles Less to CSS
            },
            {
                test: /\.css$/,
                exclude: ['/node_modules/', '/public/'],
                use: [ MiniCssExtractPlugin.loader, 'style-loader', 'css-loader']
            },
            {
                test: /\.scss$/,
                exclude: ['/node_modules/', '/public/'],
                use:  [  'style-loader', MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader']
            },
        ],
    },
    plugins: [
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery'
        }),
        new MiniCssExtractPlugin({
            filename: 'css/style.min.css',
            options: {
                minimize: true
            }
        }),
    ]
};

