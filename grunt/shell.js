module.exports = {
  bundler: {
    command: 'bundle'
  },
  bower: {
    command: 'bower install'
  },
  bundlerUpdate: {
    command: 'bundle update'
  },
  bowerUpdate: {
    command: 'bower update'
  },
  hologram: {
    command: 'bundle exec hologram <%= pkg.hologramConfig %>'
  }
}
