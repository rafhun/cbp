module.exports = {
  local: {
    options: {
      patterns: [
        {
          json: '<%= secrets.local %>'
        }
      ]
    },
    src: '<%= pkg.srcFolders.config %>configuration.php',
    dest: '<%= pkg.buildFolders.config %>configuration.php'
  },
  staging: {
    options: {
      patterns: [
        {
          json: '<%= secrets.staging %>'
        }
      ]
    },
    src: '<%= pkg.srcFolders.config %>configuration.php',
    dest: '<%= pkg.buildFolders.config %>configuration.php'
  },
  production: {
    options: {
      patterns: [
        {
          json: '<%= secrets.production %>'
        }
      ]
    },
    src: '<%= pkg.srcFolders.config %>configuration.php',
    dest: '<%= pkg.buildFolders.config %>configuration.php'
  }
}
