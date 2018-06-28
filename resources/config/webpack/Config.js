class Config {
  constructor() {
    this.app = null
    this.target = null
    this.context = null
    this.entries = new Map()
    this.outputPath = null
    this.publicPath = null
    this.useLessLoader = false
    this.useSassLoader = false
    this.useDevServer = false
    this.useSourceMaps = false
    this.devServerPort = null
    this.devServerHost = null
    this.plugins = []
    this.loaders = []
    this.aliases = {}
    this.externals = {}
    this.lessLoaderOptionsCallback = () => {
    }
    this.splitChunksConfigurationCallback = () => {
    }
  }

  addEntry(name, src) {
    if (this.entries.has(name)) {
      throw new Error(`Duplicate name "${name}" passed to addEntry(): entries must be unique.`)
    }

    this.entries.set(name, src)
  }

  addLoader(loader) {
    this.loaders.push(loader)
  }

  addPlugin(plugin, priority = 0) {
    if (typeof priority !== 'number') {
      throw new Error('Argument 2 to addPlugin() must be a number.')
    }

    this.plugins.push({
      plugin: plugin,
      priority: priority
    })
  }
}

module.exports = Config
