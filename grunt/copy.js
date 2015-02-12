module.exports = {
  local: {
    expand: true,
    cwd: '<%= pkg.srcFolders.secrets %>',
    src: 'config-local.php',
    dest: '<%= pkg.buildFolders.config %>configuration.php',
    flatten: true,
    filter: 'isFile',
  },
  server: {
    expand: true,
    cwd: '<%= pkg.srcFolders.secrets %>',
    src: 'config-server.php',
    dest: '<%= pkg.buildFolders.config %>configuration.php',
    flatten: true,
    filter: 'isFile',
  }
}
