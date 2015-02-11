module.exports = function(grunt) {
  pkg: grunt.file.readJSON('package.json');
  var destFolder = '<%= pkg.build-folders.theme %>/<%= pkg.themeName %>/';
  var folders = {
    themeFolder: '<%= pkg.build-folders.theme %>/<%= pkg.themeName %>/'
  };

  require('time-grunt')(grunt);

  require('load-grunt-config')(grunt);
};
