const path = require('path')

const Config = require('./webpack/Config')
const config = new Config()

config.app = 'admin'
config.context = path.resolve(__dirname, '../modules/admin')
config.addEntry('app', './main.js')
config.outputPath = path.resolve(__dirname, '../../public/statics/build/admin')
config.publicPath = '/statics/build/admin/'
config.usePostCssLoader = false
config.useSassLoader = false
config.useLessLoader = false
config.useSourceMaps = true

config.aliases = {
  '@admin': path.resolve(__dirname, '../modules/admin'),
  '@core': path.resolve(__dirname, '../core')
}

module.exports = config
