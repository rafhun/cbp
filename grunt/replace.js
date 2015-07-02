module.exports = {
  local: {
    options: {
      patterns: [
        {
          json: '<%= secrets.local %>'
        }
      ]
    },
    src: '<%= config.srcFolders.config %>configuration.php',
    dest: '<%= config.buildFolders.config %>configuration.php'
  },
  staging: {
    options: {
      patterns: [
        {
          json: '<%= secrets.staging %>'
        }
      ]
    },
    src: '<%= config.srcFolders.config %>configuration.php',
    dest: '<%= config.buildFolders.config %>configuration.php'
  },
  production: {
    options: {
      patterns: [
        {
          json: '<%= secrets.production %>'
        }
      ]
    },
    src: '<%= config.srcFolders.config %>configuration.php',
    dest: '<%= config.buildFolders.config %>configuration.php'
  }
}
