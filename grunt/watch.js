module.exports = {
  options: {
    livereload: true,
  },
  jsHint: {
    files: ['<%= pkg.src-folders.js %>main.js', 'grunt/*.js', 'Gruntfile.js'],
    tasks: ['jshint'],
    options: {
      spawn: false,
    }
  },
  scripts: {
    files: ['<%= pkg.src-folders.bower %>**/*.js', '<%= pkg.src-folders.js %>**/*.js'],
    tasks: ['clean:hashes', 'concat', 'uglify', 'hashres'],
    options: {
      spawn: false,
    }
  },
  styles: {
    files: ['<%= pkg.src-folders.scss %>**/*.scss'],
    tasks: ['clean:hashes', 'sass', 'autoprefixer', 'cssmin', 'hashres', 'hologram'],
    options: {
      spawn: false,
    }
  },
  images: {
    files: ['<%= pkg.src-folders.img %>**/*.{png,jpg,gif,svg}'],
    tasks: ['imagemin'],
    options: {
      spawn: false,
    }
  },
  svg: {
    files: ['<%= pkg.src-folders.svg %>*.svg'],
    tasks: ['svgstore', 'jade', 'hashres'],
    options: {
      spawn: false,
    }
  },
  favicons: {
    files: ['<%= pkg.src-folders.images %>favicon.png'],
    tasks: ['favicons', 'htmlmin', 'jade', 'hashres'],
    options: {
      spawn: false,
    }
  },
  jade: {
    files: ['<%= pkg.src-folders.jade %>*.{jade,html}'],
    tasks: ['jade', 'hashres'],
    options: {
      spawn: false,
    }
  },
  hologram: {
    files: ['<%= pkg.src-folders.scss %>README.md'],
    tasks: ['hologram'],
    options: {
      spawn: false,
    }
  }
}
