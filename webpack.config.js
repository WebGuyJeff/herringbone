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
		minimizer: [
			new CssMinimizerPlugin(),
			new TerserWebpackPlugin()
		],
		minimize: false
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
		} ),
		new BrowserSyncPlugin ( {
			// browse to http://localhost:3000/ during development.
			port: 3000,
			files: [
				'**/*.php',
				'**/*.(js|css|scss)',
				'!./node_modules',
				'!./vendor',
				'!./dist',
				'!./src'
			],
			/*
			 * 'proxy' is the address where your WordPress site runs on locally. WordPress settings
			 * site URL must be set to 'localhost:port' for this to work.
			 */
			proxy: 'localhost:8001',
			ui: { port: 3001 }, // BrowserSync UI.
			/*
			 * injectChanges: true,
			 * reloadDelay: 0,
			 * cors: true
			 */
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
