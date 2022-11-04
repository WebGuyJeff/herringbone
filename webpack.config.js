const path = require('path');

module.exports = {
	mode: "production",
	// "production" | "development" | "none"
	// Chosen mode tells webpack to use its built-in optimizations accordingly.
	entry: './src/index.js',
	// defaults to ./src
	// Here the application starts executing
	// and webpack starts bundling
	output: {
		// options related to how webpack emits results
		filename: 'bundle.js',
		path: path.resolve( __dirname, 'js' ),
	},
	optimization: {
		minimize: true,
	},
};