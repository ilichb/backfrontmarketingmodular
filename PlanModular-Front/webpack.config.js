const path = require('path');

module.exports = {
    entry: './src/js/main.js',
    output: {
        path: path.resolve(__dirname, './'),
        filename: 'bundle.js',
    },
    watchOptions: {
        ignored: '**/node_modules',
    },
};