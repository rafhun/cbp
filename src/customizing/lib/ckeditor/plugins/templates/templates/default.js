CKEDITOR.addTemplates(
  "default",{imagesPath:CKEDITOR.getUrl(CKEDITOR.plugins.getPath("templates")+"templates/images/"),

  // Template definitions
  // add templates below according to the examples
  templates:
  [
    {
      title: "Teaser Block",
      image: 'template1.gif',
      description: 'Vorlage zur Erstellung eines Teaserblocks f&uuml;r die Schnelleinstiege', // description here
      html:
        '<div class="col-sm-6">'+
          '<div class="teaser_box">'+
          '<h2>Angebot</h2><div class="img-container">'+
          '<img alt="Angebot" src="http://fakeimg.pl/750x375" /></div>'+
          '<ul>'+
          ' <li><a href="#">Erkennungsmerkmale</a></li>'+
          ' <li><a href="#">Kosten und Pr&auml;vention</a></li>'+
          ' <li><a href="#">Fragen und Antworten</a></li>'+
          ' <li><a href="#">Blindtext</a></li>'+
          ' <li><a href="#">Blindtext 2</a></li>'+
          '</ul>'+
          '</div>'+
          '</div>' // add template html
    },
    {
      title: "Beschreibungsliste",
      image: 'template1.gif',
      description: 'Erstellt Liste mit kursiven Titeln plus Beschreibung darunter. Bsp: unter Angebote Klinik.', // description here
      html:
        '<ul><li><em>Titel</em><br>Beschreibung</li><li><em>n&auml;chster Titel (einf&uuml;gen mit Enter)</em><br>Beschreibung (auf diese Zeile wechseln mit Shift + Enter)</li></ul>' // add template html
    },
    {
      title: "zwei Bilder nebeneinander",
      image: 'template1.gif',
      description: 'Zwei Bilder nebeneinander im Content. Mobile wird nur das erste angezeigt',
      html:
        '<div class="row content-image-row"><div class="col-sm-6"><img src="http://fakeimg.pl/750x350"></div><div class="col-sm-6 hidden-xs"><img src="http://fakeimg.pl/750x350"></div></div>'
    }
  ]
}); // end addTemplates
