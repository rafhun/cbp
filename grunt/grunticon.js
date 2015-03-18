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
        'pdf-hover': ['.icon-pdf:hover'],
        'plus': ['.accordion-title'],
        'close': ['.accordion-title.in']
      },
    }
  }
}
