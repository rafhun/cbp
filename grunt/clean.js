module.exports = {
  hashes: ['<%= destFolder %>{style.min.*.css,script.min.*.js}'],
  html: ['<%= destFolder %>*.html'],
  images: ['<%= destFolder %><%= pkg.buildFolders.img %>'],
  dest: ['<%= destFolder %>'],
  unhashed: ['<%= destFolder %>{style.min.css,script.min.js}']
}
