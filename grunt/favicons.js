module.exports = {
  options: {
    html: '<%= pkg.srcFolders.jade %>favicons.html',
    coast: true,
    firefox: true,
    androidHomescreen: true,
  },
  icons: {
    src: '<%= pkg.srcFolders.images %>favicon.png',
    dest: 'wwwroot/'
  }
}
