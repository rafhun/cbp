module.exports = {
  local: {
    expand: true,
    cwd: '<%= pkg.source-folders.secrets %>',
    src: 'config-local.php',
    dest: '<%= pkg.build-folders.config %>configuration.php',
    flatten: true,
    filter: 'isFile',
  },
  server: {
    expand: true,
    cwd: '<%= pkg.source-folders.secrets %>',
    src: 'config-server.php',
    dest: '<%= pkg.build-folders.config %>configuration.php',
    flatten: true,
    filter: 'isFile',
  }
}
