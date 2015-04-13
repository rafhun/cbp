CKEDITOR.addTemplates(
  "default",{imagesPath:CKEDITOR.getUrl(CKEDITOR.plugins.getPath("templates")+"templates/images/"),

  // Template definitions
  // add templates below according to the examples
  templates:
  [
    {
      title: "Section Container",
      image: 'template1.gif',
      description: 'Vorlage zur Erstellung eines Inhaltsabschnitts inkl. Metaangaben', // description here
      html:
        '<section class="content-section">'+
          '<h2 class="content-section-title">Titel des Abschnitts</h2>'+
          '<p class="content-section-meta">Metaangaben zum Abschnitt</p>'+
          '<p>Inhalte</p>'+
        '</section>' // add template html
    },
    {
      title: "Section Container zweispaltig",
      image: 'template1.gif',
      description: 'Vorlage zur Erstellung zweier Inhaltsabschnitte nebeneinander inkl. Metaangaben. ACHTUNG bei der Verwendung dieses Templates sicherstellen, dass die Inhaltsvorlage content_nested ausgewählt ist und auch alle anderen Inhalte in Abschnitten sind.', // description here
      html:
        '<section class="content-section-two">'+
          '<h2 class="content-section-title">Titel des Abschnitts 1</h2>'+
          '<p class="content-section-meta">Metaangaben zum Abschnitt</p>'+
          '<p>Inhalte</p>'+
        '</section>'+
        '<section class="content-section-two">'+
          '<h2 class="content-section-title">Titel des Abschnitts 2</h2>'+
          '<p class="content-section-meta">Metaangaben zum Abschnitt</p>'+
          '<p>Inhalte</p>'+
        '</section>' // add template html
    }
  ]
}); // end addTemplates
