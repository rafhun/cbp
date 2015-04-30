CKEDITOR.addTemplates(
  'default',{imagesPath:CKEDITOR.getUrl(CKEDITOR.plugins.getPath('templates')+'templates/images/'),

  // Template definitions
  // add templates below according to the examples
  templates:
  [
    {
      title: 'Section Container',
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
      title: 'Section Container zweispaltig',
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
    },
    {
      title: 'Accordion',
      image: 'template1.gif',
      description: 'Vorlage zur Erstellung eines Accordions, welches bspw. für Fragen &amp; Antworten verwendet wird.', // description here
      html:
        '<h3 class="accordion-title">'+
          '<a class="accordion-link" href="#">Titel/Frage</a>'+
        '</h3>'+
        '<div class="accordion-container>'+
          '<p>Inhalt des Accordions</p>'+
          '<h4 class="accordion-subheading">Accordion Untertitel</h4>'+
          '<ul class="pdf-list">'+
            '<li><a href="#" class="icon-pdf link-icon">Zur Auflistung von PDF Files</a></li>'+
            '<li><a href="#" class="icon-pdf link-icon">Falls nicht benötigt, löschen</a></li>'+
          '</ul>'+
        '</div>' // add template html
    },
    {
      title: 'Galerie 4 Bilder',
      image: 'template1.gif',
      description: 'Vorlage zur Erstellung einer Galerie, mit vier Bildern (siehe Seite Praxis).', // description here
      html:
        '<section class="lightbox-previews">'+
          '<figure class="lightbox-links"><a data-lightbox="gallery-1" data-title="Bild 1" href="//fakeimg.pl/1000x720?text=Bild1"><img alt="" src="//fakeimg.pl/300?text=Bild Praxis" /> </a>'+
            '<figcaption>Bildbeschrieb</figcaption>'+
          '</figure>'+
          '<figure class="lightbox-links"><a data-lightbox="gallery-1" data-title="Bild 1" href="//fakeimg.pl/1000x720?text=Bild2"><img alt="" src="//fakeimg.pl/300?text=Bild Praxis" /> </a>'+
            '<figcaption>Bildbeschrieb</figcaption>'+
          '</figure>'+
          '<figure class="lightbox-links"><a data-lightbox="gallery-1" data-title="Bild 1" href="//fakeimg.pl/1000x720?text=Bild3"><img alt="" src="//fakeimg.pl/300?text=Bild Praxis" /> </a>'+
            '<figcaption>Bildbeschrieb</figcaption>'+
          '</figure>'+
          '<figure class="lightbox-links"><a data-lightbox="gallery-1" data-title="Bild 1" href="//fakeimg.pl/1000x720?text=Bild4"><img alt="" src="//fakeimg.pl/300?text=Bild Praxis" /> </a>'+
            '<figcaption>Bildbeschrieb</figcaption>'+
          '</figure>'+
        '</section>' // add template html
    }
  ]
}); // end addTemplates
