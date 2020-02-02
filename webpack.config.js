const path = require('path')

module.exports = {
    entry: './frontend/js/main.js',
    output: {
        filename: 'bundle.js',
        path: path.resolve(__dirname, 'public/dist/js')
    },
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
            'vue$': 'vue/dist/vue.esm.js'
        }
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: '/node_modules/',
                use: {
                    loader: 'babel-loader'
                }
            },
            {
                test: /\.vue$/,
                exclude: '/node_modules/',
                use: {
                    loader: 'vue-loader'
                }
            }
        ]
    }
}