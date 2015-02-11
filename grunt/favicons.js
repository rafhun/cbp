module.exports = {
  options: {
    html: '<%= pkg.source-folders.jade %>favicons.html',
    coast: true,
    firefox: true,
    androidHomescreen: true,
  },
  icons: {
    src: '<%= pkg.source-folders.images %>favicon.png',
    dest: 'wwwroot/'
  }
}
