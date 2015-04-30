# Instruktionen
Auf dieser Seite werden die wichtigsten Prinzipien und Anleitungen in Bezug auf die Erfassung von verschiedenen Inhalten behandelt. Die detaillierten Instruktionen zu Contrexx können dem offiziellen Handbuch und weiteren Dokumentationen, welche auf der [offiziellen Website](https://www.cloudrexx.com/de/Support) zu finden sind, entnommen werden, hier wird schwergewichtig die spezialisierte Anwendung dieser Seite beschrieben.

## Arbeiten im Editor
Alle Inhalte werden über den Backend Editor erfasst und verwaltet. Dieser Editor beinhaltet verschiedene Funktionen, welche auch aus dem typischen Texteditor wie Microsoft Word bekannt sein sollten. Zu beachten sind die folgenden Punkte:

### Vorlagen
Um komplexere Inhalte sauber darzustellen stehen einige Vorlagen zur Verfügung. Mithilfe dieser Sollte die Erstellung neuer Inhalte problemlos ablaufen. Zur Zeit stehen drei Vorlagen zur Verfügung:

* Vorlage zur Erstellung eines Inhaltsabschnitts inkl. Metaangaben
* Vorlage zur Erstellung zweier Inhaltsabschnitte nebeneinander inkl. Metaangaben
* Vorlage zur Erstellung eines Accordions

#### Vorlagen zur Erstellung eines Inhaltsabschnitts inkl. Metaangaben

Die ersten beiden Vorlagen kommen insbesondere im Bereich Presseberichte und TV Auftritte zur Anwendung. Um bspw. einen neuen Pressebericht zu erfassen, kann mit dem Cursor an die entsprechende Stelle navigiert werden. Nach einem Klick auf die Schaltfläche in der Toolbar, erscheint der Dialog zur Auswahl der Vorlagen. Nach einem Klick auf die entsprechende Vorlage wird diese automatisch an der Stelle des Cursors eingefügt.

#### Vorlage zur Erstellung eines Accordions

Accordions werden z. B. bei den häufigen Fragen eingesetzt. Dies sind die Container, welche sich ausklappen lassen um mehr Content anzuzeigen. Diese sind identisch einzufügen. Um ein Accordion standardmässig, nach dem Laden der Seite, offen anzuzeigen, kann ein entsprechender Stil ergänzt werden (siehe unten).

### Stile
Neben dem Dropdown Menu Format, welches aus Textprozessoren bekannt ist, existiert auch ein Dropdown namens Stile. Dieses ist nur aktiviert, wenn auch ein Stil auf das zur Zeit ausgewählte Element angewendet werden kann. Zur Zeit existieren zwei Arten von Stilen:

* Icons für Links auf entsprechende Medien (PDF, Film, externer Link, ...)
* Stil um ein Accordion aufzuklappen

Die Link Icons kommen überall dort zum Einsatz, wo Medien oder externe Seiten verlinkt werden. Nachdem der Link gemäss der allgemeinen Anleitung eingefügt wurde, kann der Cursor darauf navigiert werden, woraufhin das Stile Dropdown automatisch aktiviert wird. Nachfolgend kann aus dem Dropdown der entsprechende Stil gewählt werden.

Nach dem Einfügen von Accordions gibt es die Möglichkeit, diese standardmässig offen anzuzeigen. Dazu kann nach der Erstellung des Accordions aus der Vorlage, dessen Titel annavigiert werden und daraufhin in den Stilen Accordion öffnen gewählt werden.

### Bilder
Bilder werden über das entsprechende Symbol zum Content hinzugefügt. Ein Klick auf das Symbol öffnet den Dialog zur Auswahl der Bilder. Nach dem Klick auf Server durchsuchen gibt es die Möglichkeit neue Bilder hochzuladen. Eine sauber strukturierte Ordnerstruktur ist dabei sehr zu empfehlen.

Nachdem per Doppelklick ein Bild ausgewählt wurde ist es sehr wichtig einen sogenannten Alt-Text zu erfassen, da dieser insbesondere für die Google Suche relevant ist. Des weiteren ist es sehr wichtig **die automatisch eingefügten Zahlen wieder zu löschen**. Leider lässt sich der Editor nicht anders konfigurieren. Falls die Zahlen nicht gelöscht werden, verhalten sich die Bilder nicht responsiv (passen sich also nicht ihren Containern an). Falls nach dem Einfügen eines Bildes etwas nicht korrekt wirkt, als erstes überprüfen, ob diese Zahlen für Breite und Höhe gelöscht wurden.

Zur Ausrichtung des Bildes ebenfalls nicht das Dialogfeld benutzen. Nach dem Klick auf ok, wird das Bild im Editor eigefügt. Mit einem Klick darauf wird es markiert und damit das Dropdown Menu Stile in der Toolbar aktiviert (mehr zu Stilen oben). Dort stehen nun je nach Konfiguration eine oder mehrere Optionen zur Verfügung, wie das Bild in der Seite ausgerichtet werden soll.

## Team und Assistenzärzte
Das Team und die Assistenzärzte werden nicht im normalen Content Manager erfasst, sondern in den Inhaltscontainern. Das empfohlene Vorgehen zum Erfassen neuer Mitarbeitenden ist es, einen existierenden Eintrag über die entsprechende Schaltfläche zu kopieren. Darauf können im folgenden Editor die entsprechenden Angaben angepasst und danach gespeichert werden. Die neu erfasste Person wird automatisch zu unterst eingeordnet. Über die Zahlen in der Übersicht kann die Reihenfolge des Teams nach eigenen Wünschen angepasst werden.

Um einen Assistenzarzt vom Team ins Archiv der Assistenzärzte zu verschieben, muss bloss die Kategorie des entsprechenden Blocks angepasst werden.

# Styleguide
The SCSS is structured in a meaningful way that should provide the best possible order in the resulting CSS file. The partials are put into folders and through this are sorted logically. Here is a quick overview:
## Dependencies
All we have defined here are variables, mixins or functions. If only these files were compiled the resulting CSS should be empty. At the time we have three specific files within this folder imported in the following order:
### Color
All colors used throughout the site should be defined within this file. Use them according to the following example:

```scss
$red: #f00;
$blue: #00f;
$blue-lighter: lighten($blue, 5%);

$color-primary: $red;
$color-border-normal: $blue;
$color-border-lighter: $blue-lighter;
```

This makes replacing colors easy and still keeps semantic names.

Also if you are thinking about providing different color schemes do not forget to use the `!default` flag, so variables could be redefined later in a theme file.

### Typography
This is used to provide vertical rythm, font families, font definitions and similar. Again remember that no CSS should be rendered when this file is compiled.

### Layout
Common layout rules such as the susy definitions or breakpoints and similar should be defined within this file.

## Base
This folder contains partials that address the basic styling of the page. There should not be any classes in this section. This folder is prepopulated with files containing parts of Nicolas Gallagher's `normalize.css` project. The following partials are being used:

- site: for html, body and selection tags
- text-inline: all inline text like a, b, strong, abbr, ...
- text-block: all text elements that are rendered as blocks (headings, p, blockquote, ...)
- lists
- tables
- forms
- media: img, svg, audio, video tags
- code: pre, code, var, etc

## Components
This folder should be filled with modular, reusable UI components. Take care to only define the components themselves within this file so they can easily be integrated in any part of the page.

## Working With Breakpoints (Using Susy)
Susy is used for grids and as of version 2.2 now also supports its own breakpoint system. Everything susy related is defined in the file `dependencies/_layout.scss`. Here is a guide on how to use breakpoints with Susy:

```scss
body {
    background: red;

    @inlcude susy-media(sm) {
        background: blue;
    }
}
```

The mixin is very easy to use. Just reference the variable from the map you have created. It is also possible to put in concrete values should you need a breakpoint or rather tweakpoint for certain components. Also with the mixin it is currently not possible to automatically create a min-width, max-width pairing by just referencing to variables. Some extra stuff has to be defined for this to work.

## Editor Styles
The `main.scss` file defines the boolean `$EDITOR-STYLES` on top of the whole document. This boolean enables us to define editor specific styles which is especially important for things that may be hidden in the frontend by default. The boolean should be used as follows:

```
.element {
    @if $EDITOR-STYLES {
        display: block;
    } @else {
        display: none;
}
```

Therefore if `$EDITOR-STYLES` is set to true, the `.element` will not be hidden, while the default setting for the frontend is for it to be hidden. Think about the editor styles when writing your styles in the first place to prevent a search and rescue operation once you are finished to locate where styles might be that should show up in the editor.

To create the editor stylesheet it is recommended to set the `$EDITOR-STYLES` variable to true, then run `grunt editorStyles` and immediately after that reset the variable to false. Otherwise you might get unexpected results.
