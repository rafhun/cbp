module.exports = {
  options: {
    args: ['--verbose'],
    recursive: true,
    exclude: ['.git', '.hg', '.svn', '.DS_Store', '._*', 'Thumbs.db', '/tmp/cache/**'],
    include: ['/tmp/cache/.htaccess'],
  },
  staging: {
    options: {
      src: 'wwwroot/',
      dest: '<%= secrets.staging.ascms_root %>',
      host: '<%= secrets.staging.sshHost %>',
      delete: true
    }
  },
  production: {
    options: {
      src: 'wwwroot/',
      dest: '<%= secrets.production.ascms_root %>',
      host: '<%= secrets.production.sshHost %>',
      delete: true
    }
  },
  productionDry: {
    options: {
      args: ['--verbose', '--dry-run'],
      src: 'wwwroot/',
      dest: '<%= secrets.production.ascms_root %>',
      host: '<%= secrets.production.sshHost %>',
      delete: true
    }
  }
}
