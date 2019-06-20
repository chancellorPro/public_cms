/**
 * Include .env
 */
require('dotenv').config({path: __dirname + '/.env'});

/**
 * Dependencies
 */
const path = require('path');
const webpack = require('webpack');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");

/**
 * Paths
 */
const SOURCE_PATH = path.join(__dirname, './resources/assets/app');
const PUBLIC_PATH = path.join(__dirname, './public/app');

/**
 * Is production
 * @type {boolean}
 */
const PRODUCTION = process.env.APP_ENV == 'prod';

/**
 * WebPack configuration body
 */
module.exports = {
    mode: PRODUCTION ? 'production' : 'development',
    devtool: PRODUCTION ? null : 'inline-source-map',
    context: SOURCE_PATH,
    entry: {
        main: './index.js'
    },
    output: {
        path: PUBLIC_PATH,
        publicPath: "/",
        filename: 'js/[name].js',
        chunkFilename: 'js/[name].js',
    },
    plugins: [
        /**
         * Require ignore plugins
         */
        // new webpack.IgnorePlugin({
        //     resourceRegExp: /^\.\/locale$/,
        //     contextRegExp: /moment$/
        // });
        // new webpack.ContextReplacementPlugin(
        //     /\/js\//,
        //     /alert/
        // ),

        /**
         * Auto require libs
         */
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery'
        }),

        /**
         * Define global constants
         */
        new webpack.DefinePlugin({
            APP_ENV: JSON.stringify(process.env.APP_ENV),
        }),

        /**
         * Extract css from js
         */
        new MiniCssExtractPlugin({
            filename: 'css/[name].css',
            chunkFilename: 'css/[name].css',
        }),
    ],
    module: {
        rules: [
            {
                test: /\.js$/,
                include: SOURCE_PATH,
                exclude: /\/node_modules\/|\/vendor\//,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: [
                            '@babel/env'
                        ]
                    }
                }
            },
            {
                test: /\.(s?css)$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'sass-loader',
                ]
            },
            {
                test: /\.(png|jpg|gif|svg|eot|ttf|woff|woff2)$/,
                loader: 'url-loader',
                options: {
                    outputPath: 'fonts/',
                    publicPath: '../fonts/',
                    name: '[name].[ext]',
                    limit: 10000
                }
            }
        ]
    },
    resolve: {
        alias: {
            components: path.resolve(__dirname, SOURCE_PATH + '/components'),
            modules: path.resolve(__dirname, SOURCE_PATH + '/modules'),
            listeners: path.resolve(__dirname, SOURCE_PATH + '/listeners'),
            helpers: path.resolve(__dirname, SOURCE_PATH + '/helpers'),
            handlers: path.resolve(__dirname, SOURCE_PATH + '/handlers'),
            exceptions: path.resolve(__dirname, SOURCE_PATH + '/exceptions'),
        },
        extensions: ['.js']
    },

    optimization: {
        minimizer: [
            /**
             * JS optimization
             */
            new UglifyJsPlugin({
                uglifyOptions: {
                    output: {
                        comments: false,
                    },
                    compress: {
                        warnings: false,
                        drop_console: true,
                    },
                },
                parallel: true,
            }),

            /**
             * CSS optimization
             */
            new OptimizeCSSAssetsPlugin({
                cssProcessorPluginOptions: {
                    preset: ['default', { discardComments: { removeAll: true } }],
                },
            }),
        ],

        splitChunks: {
            cacheGroups: {
                default: false,

                /**
                 * Common chunk
                 */
                // commons: {
                //     name: 'common',
                //     chunks: 'all',
                //     enforce: true,
                //     minChunks: 2
                // },

                /**
                 * Vendor
                 */
                vendor: {
                    chunks: 'initial',
                    name: 'vendor',
                    test: /[\\/](node_modules|vendor)[\\/]/,
                    enforce: true
                },
            }
        },
    }
};
