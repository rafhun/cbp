module.exports = {
  icons: {
    files: [{
      expand: true,
      cwd: '<%= pkg.srcFolders.iconsMin %>',
      src: ['*.svg', '*.png'],
      dest: '<%= destFolder %><%= pkg.buildFolders.icons %>'
    }],
    options: {
      'compressPNG': true,
      'colors': {
        lines: '#CACACA',
      },
      'dynamicColorOnly': true,
      'customselectors': {
        'link-hover': ['.icon-link:hover'],
        'mail-hover': ['.icon-mail:hover'],
        'movie-hover': ['.icon-movie:hover'],
        'pdf-hover': ['.icon-pdf:hover'],
        'phone-hover': ['.icon-phone:hover'],
        'plus': ['.accordion-title'],
        'close': ['.accordion-title.in']
      },
    }
  }
}
