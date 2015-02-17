# Christen Ortho – Styleguide
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
