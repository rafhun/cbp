module.exports = {
  hashes: ['<%= destFolder %>{style.min.*.css,script.min.*.js}'],
  hashedCss: ['<%= destFolder %>style.min.*.css'],
  hashedJs: ['<%= destFolder %>script.min.*.js'],
  html: ['<%= destFolder %>*.html'],
  images: ['<%= destFolder %><%= pkg.buildFolders.img %>'],
  dest: ['<%= destFolder %>'],
  unhashed: ['<%= destFolder %>{style.min.css,script.min.js}'],
  contrexx: ['wwwroot/images/**/*.{jpg,jpeg,gif,png,thumb,pdf,ico,db,html}', 'wwwroot/themes/skeleton_3_0'],
  editorStyles: ['<%= destFolder %>style-ck.css'],
  editorConfig: ['wwwroot/core/Wysiwyg/ckeditor.config.js.php']
}
