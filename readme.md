# Contrexx Development Framework
This framework uses advanced methodologies to ensure efficient and clean development of Contrexx websites and especially their themes.

## Folder Structure
The basic folder structure is defined respectively mirrored within `package.json` file. All paths needed in grunt are defined therein to make it easy for you to adapt the structure to your needs. Folder paths within grunt configuration files are all given by referencing these variables so make sure you follow the given folder structure or change your `package.json`.
To change your themes name change `themeName` in `package.json`. This automatically names your theme folder and adjusts your grunt paths.

## Grunt Tasks
Here a quick overview is given over important grunt tasks and their usage. Not everything is described and most of these tasks have been assigned to other tasks and are being run automatically.
There are two basic tasks set up which allow you to build a development version or a production version. The default task is set up as development build while `grunt ship` creates the production build. The main differences between the two tasks are:
* The copied `configuration.php` file (development variables vs. production variables)
* The JSHint rules: for production the `devel` option is set to `false` to prevent commands typically used for development (such as `alert()`) from being shipped to the server. During development however these tasks can be of great use when debugging your scripts and are therefore allowed.

### Copy Task
The copy task serves to copy files. One usage of them is to keep sensitive data out of the repository and to be able to quickly change the `configuration.php` file of Contrexx to the environment that is being used. Run `copy:local` to change to the local configuration and `copy:server` to change to the server configuration. Usually these two files only differ in the root paths given however this task makes it possible to also have different database credentials without the need to go into the config file directly. Just run the `copy:server` task before deploying to your server.

## Important File Names
A list to give you a quick overview over the filenames being used:
* Styles: style.css -> style-prefixed.css -> style.min.css
* Scripts: script.js -> script.min.js

## Processing Flow
The processing flow for the most important file types is described below.
### Jade and HTML Files
@TODO: check whether jade handles html comments correctly as they are needed to build for example the navigation list. Otherwise these files would have to be written in plain html with a seperate minification task that does not remove comments.

The `index.jade` file imports the `favicons.html` file generated by the favicons task. This file includes all links to the generated favicons. To reduce filesize our goal is to minimize all html we can. Because jade does not minify imported html the htmlmin task is run over `favicons.html` before the jade task compiles its files. Therefore the imported html is already minified and thus we reach optimal whitespace reduction. Make sure to set up the tasks correctly meaning htmlmin should always run before jade.
