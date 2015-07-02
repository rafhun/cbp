module.exports = {
  options: {
    livereload: true,
    spawn: false
  },
  jsHint: {
    files: ['<%= config.srcFolders.js %>main.js', 'grunt/*.js', 'Gruntfile.js'],
    tasks: ['jshint']
  },
  scripts: {
    files: ['<%= config.srcFolders.js %>**/*.js'],
    tasks: ['clean:hashedJs', 'concat', 'uglify', 'cssmin', 'jade', 'hashres']
  },
  styles: {
    files: ['<%= config.srcFolders.scss %>**/*.scss'],
    tasks: ['clean:hashedCss', 'sass:main', 'autoprefixer:main', 'cssmin', 'uglify', 'jade', 'hashres', 'shell:hologram']
  },
  images: {
    files: ['<%= config.srcFolders.images %>**/*.{png,jpg,gif}'],
    tasks: ['imagemin']
  },
  svg: {
    files: ['<%= config.srcFolders.svg %>*.svg'],
    tasks: ['svgstore', 'jade', 'hashres']
  },
  grunticon: {
    files: ['<%= config.srcFolders.icons %>*.svg'],
    tasks: ['svgmin', 'grunticon']
  },
  favicons: {
    files: ['<%= config.srcFolders.images %>favicon.png'],
    tasks: ['clean:hashes', 'clean:favicon','favicons', 'htmlmin', 'jade', 'hashres']
  },
  jade: {
    files: ['<%= config.srcFolders.jade %>*.{jade,html}'],
    tasks: ['clean:hashes', 'jade', 'cssmin', 'uglify','hashres']
  },
  customizing: {
    files: ['<%= config.srcFolders.customizing %>**'],
    tasks: ['clean:customizing', 'copy:customizing']
  },
  hologram: {
    files: ['<%= config.srcFolders.scss %>README.md'],
    tasks: ['shell:hologram']
  }
}
