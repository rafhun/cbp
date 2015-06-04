module.exports = {
  options: {
    args: ['--verbose'],
    recursive: true,
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
