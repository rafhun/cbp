module.exports = function(grunt) {

  require('time-grunt')(grunt);

  require('load-grunt-config')(grunt, {
    data: {
      pkg: grunt.file.readJSON('package.json'),
      config: grunt.file.readYAML('Gruntconfig.yml'),
      destFolder: '<%= config.buildFolders.theme %><%= config.themeName %>/',
      secrets: grunt.file.readJSON('secrets.json')
    },
    loadGruntTasks: {
      pattern: ['grunt-*', 'sassdown']
    }
  });
};
