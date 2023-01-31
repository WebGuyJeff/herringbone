const webpack              = require( 'webpack' )
const path                 = require( 'path' )
const MiniCssExtractPlugin = require( "mini-css-extract-plugin" )
const CssMinimizerPlugin   = require( "css-minimizer-webpack-plugin" )
const TerserWebpackPlugin  = require( "terser-webpack-plugin" )
const BrowserSyncPlugin    = require( "browser-sync-webpack-plugin" )
const THEME                = require( './wp-theme-meta.json' )

const wpThemeBanner =
'/**\n' +
' * Theme Name: ' + THEME.themeName + '\n' +
' * Theme URI: ' + THEME.themeUri + '\n' +
' * Author: ' + THEME.author + '\n' +
' * Author URI: ' + THEME.authorUri + '\n' +
' * Description: ' + THEME.description + '\n' +
' * Tags: ' + THEME.tags + '\n' +
' * Version: ' + THEME.version + '\n' +
' * Requires at least: ' + THEME.requiresAtLeast + '\n' +
' * Tested up to: ' + THEME.testedUpTo + '\n' +
' * Requires PHP: ' + THEME.requiresPhp + '\n' +
' * License: ' + THEME.license + '\n' +
' * License URI: ' + THEME.licenseUri + '\n' +
' * Text Domain: ' + THEME.textDomain + '\n' +
' */'

module.exports = {
	cache: false,
	stats: {
		// all: true,
	},
	devtool: "source-map",
	entry: {
		frontend: './src/js/frontend.js',
		customizer: './src/js/customizer.js',
		style: './src/css/style.js',
	},
	output: {
		filename: '[name].js', // js output filename.
		path: path.resolve( __dirname, 'js' ), // js output dir.
	},
	optimization: {
		minimizer: [
			new CssMinimizerPlugin(),
			new TerserWebpackPlugin()
		],
		minimize: false
	},
	plugins: [
		new MiniCssExtractPlugin( {
			filename: "../[name].css", // css output relative to 'output' path.
		} ),
		new webpack.BannerPlugin( {
			banner: wpThemeBanner, // the banner as string.
			raw: true, // if true, banner will not be wrapped in a comment.
			entryOnly: true,
			include: /style\.(css|scss)$/
		} ),
		new BrowserSyncPlugin ( {
			files: [
				'**/*.php',
				'./js/*.(js|jsx)',
				'./style.css',
				'!./node_modules',
				'!./vendor*',
				'!./dist',
				'!./src',
				'!./webpack.config.js',
				'!./webpack.zip.config.js',
				'!./package.json',
				'!./package-lock.json',
				'!./composer.json',
				'!./composer.lock'
			],
			proxy: 'localhost:8001', // Live WordPress site. WordPress site URL must be set to 'localhost:port'.
			ui: { port: 3001 }, // BrowserSync UI.
			port: 3000, // browse to http://localhost:3000/ during development.
			logLevel: "debug"
		} )
	],
	module: {
		rules: [
			{
				test: /\.(css|scss)$/,
				use: [ MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader' ]
			},
		],
	},
}
