/*
 * Trying to setup browser refresh etc... see:
 * https://carrieforde.com/webpack-wordpress/.
 */


const webpack              = require( 'webpack' )
const path                 = require( 'path' )
const MiniCssExtractPlugin = require( "mini-css-extract-plugin" )
const CssMinimizerPlugin   = require( "css-minimizer-webpack-plugin" )
const TerserWebpackPlugin  = require( "terser-webpack-plugin" )
const BrowserSyncPlugin    = require( "browser-sync-webpack-plugin" )
const THEME                = require( './wp-theme-meta.json' )

const banner =
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
	mode: "development", // "production" | "development".
	devtool: "source-map",
	entry: {
		frontend: './src/frontend.js',
		customizer: './src/customizer.js',
	},
	output: {
		filename: '[name]-bundle.js', // js output filename.
		path: path.resolve( __dirname, 'js' ), // js output dir.
	},
	optimization: {
		minimize: true,
		minimizer: [ new CssMinimizerPlugin(), new TerserWebpackPlugin() ],
	},
	plugins: [
		new MiniCssExtractPlugin( {
			filename: "../style.css", // css output.
		} ),
		new webpack.BannerPlugin( {
			banner: banner, // the banner as string.
			raw: true, // if true, banner will not be wrapped in a comment.
			entryOnly: false,
			include: /\.(js|css|scss)$/,
			/*
			 * entryOnly: true, // if true, the banner will only be added to the entry chunks.
			 * include: /\.(scss|css)$/,
			 */
		} ),
		new BrowserSyncPlugin ( {
			files: "**/*(php|js|css|scss)",
			proxy: "http://192.168.1.92:8001/"
		} )
	],
	module: {
		rules: [
			{
				test: /\.(css|scss)$/,
				use: [ MiniCssExtractPlugin.loader, "css-loader", "sass-loader" ],
			},
		],
	},
}
