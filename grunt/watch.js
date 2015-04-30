module.exports = {
  options: {
    livereload: true,
    spawn: false
  },
  jsHint: {
    files: ['<%= pkg.srcFolders.js %>main.js', 'grunt/*.js', 'Gruntfile.js'],
    tasks: ['jshint']
  },
  scripts: {
    files: ['<%= pkg.srcFolders.js %>**/*.js'],
    tasks: ['clean:hashedJs', 'concat', 'uglify', 'cssmin', 'jade', 'hashres']
  },
  styles: {
    files: ['<%= pkg.srcFolders.scss %>**/*.scss'],
    tasks: ['clean:hashedCss', 'sass:main', 'autoprefixer:main', 'cssmin', 'uglify', 'jade', 'hashres', 'hologram']
  },
  images: {
    files: ['<%= pkg.srcFolders.images %>**/*.{png,jpg,gif}'],
    tasks: ['imagemin']
  },
  svg: {
    files: ['<%= pkg.srcFolders.svg %>*.svg'],
    tasks: ['svgstore', 'jade', 'hashres']
  },
  grunticon: {
    files: ['<%= pkg.srcFolders.icons %>*.svg'],
    tasks: ['svgmin', 'grunticon']
  },
  favicons: {
    files: ['<%= pkg.srcFolders.images %>favicon.png'],
    tasks: ['clean:hashes', 'clean:favicon','favicons', 'htmlmin', 'jade', 'hashres']
  },
  jade: {
    files: ['<%= pkg.srcFolders.jade %>*.{jade,html}'],
    tasks: ['clean:hashes', 'jade', 'cssmin', 'uglify','hashres']
  },
  customizing: {
    files: ['<%= pkg.srcFolders.customizing %>**'],
    tasks: ['clean:customizing', 'copy:customizing']
  },
  hologram: {
    files: ['<%= pkg.srcFolders.scss %>readme.md'],
    tasks: ['hologram']
  }
}
