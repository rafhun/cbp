# Contrexx Development Framework
This framework uses advanced methodologies to ensure efficient and clean development of Contrexx websites and especially their themes.

## Initialize a New Project
To initialize a new project you need to fork this repo and then clone it to your work station. Change the root folder name according to your current project then `cd` into it and run `npm install`. This will install all node modules the framework needs.
After this you will be able to run `grunt setup`. This command will install all gems and bower dependencies needed for your project and concatenate all js files pulled in through bower to the `bower.js` file in the source javascript folder. With this you are ready to start development.

## Folder Structure
The basic folder structure is defined respectively mirrored within `package.json` file. All paths needed in grunt are defined therein to make it easy for you to adapt the structure to your needs. Folder paths within grunt configuration files are all given by referencing these variables so make sure you follow the given folder structure or change your `package.json`.
To change your themes name change `themeName` in `package.json`. This automatically names your theme folder and adjusts your grunt paths.

## Grunt Tasks
Here a quick overview is given over important grunt tasks and their usage. Not everything is described and most of these tasks have been assigned to other tasks and are being run automatically. They are more or less described in the order that you would need them or how they are used within the build tasks.

### Default and Shipping Task
There are two basic tasks set up which allow you to build a development version or a production version. The default task is set up as development build while `grunt ship` creates the production build. The main differences between the two tasks are:
* The copied `configuration.php` file (development variables vs. production variables)
* The JSHint rules: for production the `devel` option is set to `false` to prevent commands typically used for development (such as `alert()`) from being shipped to the server. During development however these tasks can be of great use when debugging your scripts and are therefore allowed.

### Setup
There are two setup tasks configured, one for the initial setup and one that can be used to update gem and bower dependencies after the project has been setup. Run `grunt setup` immediately after `npm install` to initialize your installation. The task loads in all gems defined in the `Gemfile` (respecting given versions if `Gemfile.lock` is found) and prepares all bower dependencies according to the `bower.json` file. All bower javascript files are automatically concatenated and put into the `src/js` folder, prepared for combining them with your other scripts. Bower scripts are automatically ordered correctly according to their dependencies. Should this not work as it should for a component add the dependency yourself to the `grunt/bower_concat.js` file. Refer to the [documentation](https://www.npmjs.com/package/grunt-bower-concat#dependencies) for further instructions.
To update gem and bower dependencies run `grunt setupUpdate`. Make sure you are in a safe testing environment (i. e. a new testing branch or similar) so you can easily revert should something break because of an update. Thoroughly test your installation after running this update task. Should everything work fine put it into production otherwise go back to the previously used versions.

### Replace
Takes all your configuration data from the `secrets.json` file in your root and builds a valid Contrexx `configuration.php` file. You have the possibility to define a local and a server environment. The task is also part of the respective build tasks so you automatically get the correct configuration for the chosen environment.
* `grunt replace:local` fills in the credentials for your local environment.
* `grunt replace:server` is used to create the server environment configuration.

### Clean
This task is responsible for wiping out the whole build folder before a new build starts. To keep the filesystem clean while in development several subtasks have been defined which are called by the watch task:
* Immediately after installing Contrexx you have the opportunity to run `grunt clean:contrexx` which will remove all content Contrexx puts into the `images/` folder, while keeping its folder structure intact since it is needed this way by Contrexx, as well as the standard skeleton theme which will not be needed. Still this allows you to upload a clean folder containing only files you put there yourself (in the best case only minified/compressed images).
* `grunt clean:hashes` is used to delete the previously hashed script and stylesheet files. Since hashres always hashes both files they can both be deleted.
* `grunt clean:html` deletes all `.html` files in the build folder. This task can be used to completely rebuild your jade templates. It is not integrated to another grunt task and as such can only be run on its own.
* `grunt clean:images` cleans only the `images` folder in the theme folder. Use it to clean up previously compressed images (i.e. if you get an error or wrong minification). As such this task is not part of any defined grunt tasks.
* `grunt clean:dest` wipes out the whole build folder. Use this if you want to completely rebuild all your resources.
* `grunt clean:unhashed` cleans up your unhashed styles and javascript in the build folder. Use this before deploying to the server if you do not wish for your unhashed files to be available there.

### Imagemin
Used to compress images to their minimum file size. Since there are two different image locations in the CMS there are two tasks:
* `grunt imagemin:contentImg` is used for images with no direct connection to your theme. It is run on the `src/images/content-images` folder which should only contain images that are part of the content.
* All images that are part of the theme should be put into the `src/images/theme` folder and are compressed by the `grunt imagemin:themeImg` task. Put all images referenced from your CSS in here. However keep these files to a minimum while trying to use as many svg's as possible throughout the site.

### Hashres
The hashres task is used for cache busting your assets. It automatically adds an 8 charachter long hash from the file contents to your styles and script file. This means that the hash only changes if the file contents actually changed, perfect for cache busting.
The task furthermore changes the links in the `index.html` to include the generated hash. To keep your build folder clean the hashed files are wiped out automatically before the task is run however the unhashed files will not be replaced.
Before deployment or when running the `grunt ship` task, the source files are wiped after the hashes are created to keep the files on your server clean.

### BrowserSync
For BrowserSync to work correctly it is crucial that you adjust the `devUrl` key in your `package.json` file to reflect your develpoment url. As Contrexx is based on PHP and MySQL we have to use BrowserSync with the proxy option to lead it to the right server. Do not make it a habit to use BrowserSync on its own. It is part of the default task and watches for changes in any CSS files within your theme folder.
BrowserSync is part of the default task so just run `grunt` and BrowserSync is automatically initialized before the watch task. Should you want to run just the BrowserSync and Watch task run `grunt bsWatch`, which will initialize BrowserSync and then start the watch task.

## Important File Names
A list to give you a quick overview over the filenames being used:
* Styles: style.css -> style-prefixed.css -> style.min.css
* Scripts: script.js -> script.min.js

## Processing Flow
The processing flow for the most important file types is described below.
### Jade and HTML Files
@TODO: check whether jade handles html comments correctly as they are needed to build for example the navigation list. Otherwise these files would have to be written in plain html with a seperate minification task that does not remove comments.

The `index.jade` file imports the `favicons.html` file generated by the favicons task. This file includes all links to the generated favicons. To reduce filesize our goal is to minimize all html we can. Because jade does not minify imported html the htmlmin task is run over `favicons.html` before the jade task compiles its files. Therefore the imported html is already minified and thus we reach optimal whitespace reduction. Make sure to set up the tasks correctly meaning htmlmin should always run before jade.

## Contrexx Configuration
1. Set up your local (and remote) database through phpmyadmin. Set up a new MySQL database for your Contrexx installation and create a new user for the database. The recommended way of doing this is by creating a new user and check the "Create database with same name and assign all rights" box. Make sure to put down the credentials somewhere.
2. Clone the repo into your local/remote webserver. The recommended setup is to prepare a virtual host, which uses the repo name as its domain and the `wwwroot` folder in the repo as web root. A good tutorial on setting this up on OS X can be found [here](http://mallinson.ca/osx-web-development/). Following this example you would clone the repo into your `/www/sites/` folder.
3. Download the latest version of Contrexx from [here](https://www.cloudrexx.com/de/Software). Unzip the download to the `wwwroot` folder of this repo.
4. Open the chosen server in your browser and follow the Contrexx installation wizard. Provide your credentials when asked for them. This step sets up the correct configuration file and creates the database structure. Should you run into access rights problems in your **local** environment try running the following command on your root folder: `sudo chmod -R a+w /path/to/webroot` (be careful, only use this command on your local machine and if you can trust everyone with access to it!). Alternatively you could run `sudo chown -R _www /path/to/webroot` which assigns ownership to the `_www` apache user, however this can make working with the files cumbersome as you will have to authenticate as admin more often.
5. After successfully installing Contrexx open the `secrets-template.json` file and edit it with the credentials you have just created. In the basic installation you have the ability to provide credentials for two servers (one for development, one for production). However it is possible to add further servers in valid JSON (just follow the example) if you adjust the replace task (`grunt/replace.js`) for those. Then save the file as `secrets.json`. Do not worry, this file is ignored by git by default so your credentials will not end up in your repo.
6. Make sure not to put the `configuration.php` or `secrets.json` file into any public repo as this could compromise your credentials.
7. Run `grunt replace:local` which copies your local credentials into the configuration file and `grunt replace:server` to change them to the ones for the server. These tasks are also part of the basic build tasks to create a complete local resp. server build. Also run this task after you changed something in your `secrets.json` file to update the configuration with the latest credentials.
8. Use `grunt clean:contrexx` to get rid of all standard contrexx files you will not need for your theme.
9. Pull in dependencies by running `grunt:setup`.
10. Adjust the local URL in `package.json` to ensure BrowserSync runs correctly.
11. Commit your project after this step then you will be ready to start working on the theme.
12. Run `grunt` and start developing your theme.

## Contrexx Editor Configuration
A basic editor configuration has been saved to `src/config`. This configuration will automatically be copied to the right place in the installation upon running the grunt task. It sets the following good standards:
* Enter-Mode is set to p (pressing enter results in a new paragraph), Shift+Enter is set to br (linebreak).
* Paste is forced as plain text, so no styling will be applied to pasted elements (because otherwise the editor puts really ugly spans with inline styles around certain pasted elements which override the CSS file and thus are bad)
* A custom stylesheet located in `/themes/rafhun/editor-styles.css` is loaded. Should this file not (yet) exist it fails silently which does not make this a problem at all. See more about the editor stylesheet below.
* Templates are by default set to replace all existing content. This default is overriden since we use templates mainly for components or design elements to be added to content (i. e. accordions).
* Editor tab spaces are set to two (as they are in the linters) for consistency between the codebases.
* The styles menu is added to all editors that by default only feature the format menu. We use styles mainly to apply classes to elements (i. e. link icons or lightboxes).
* @TODO: remove everything from the toolbar that we do not really need or do not want the customer to use.

## Editor Styles
A boolean variable has been prepared in the styles to set editor styles. You can find more information about it directly in the styleguide. By running the task `grunt editorStyles` the editor stylesheet is created and saved to the path given in the editor configuration (see above).

## Contrexx Customizing
Some generally important customizings have already been prepared in `src/customizing`. This folder gets copied over to `wwwroot/customizing` upon running the default grunt task and whenever the watch task discovers an edit. **Important:** Remember to turn on customizings in the Contrexx backend to enable these basic customizings as well as further ones you plan to implement. Following is a short description of the customizings contained within the standard repo.

### Editor
The editor's style menu as well as its templates are defined here. More information about the use of the files can be found directly within them.

### Frontend Editing
Frontend Editing is disabled for titles because of a problem with the editor configuration. Contrexx puts a full blown editor around the page title inside of the h1 tags. This means that a p tag is automatically added to the title which makes absolutely no sense. An easy solution to keep the editing function would be to either include the h1's in the editor or not use the whole editor but only a standard text input which would make more sense anyway since in the backend we also only have a text input. However until this is fixed by Contrexx we make titles uneditable in the frontend.

@TODO
### hreflang Tags for multilingual sites
For multilingual sites Google recommends the use of hreflang tags to indicate the language of the current document as well as the locations of the translations. This means just good practice and therefore a customizing has been created which automatically creates the tags needed.

## Continuing Work on an Installed Repo
If you have just cloned a repo that contains a Contrexx that has already be installed, make sure that you find a `db/backup-TIMESTAMP.sql` file in it. Set up your database with your own `secrets.json` file or use the same one as the person who previously installed Contrexx (it does not really matter). After you have prepared the database take the latest MySQL dump from the `db/` folder and import it either through the console or with phpmyadmin. Once this is done you have a Contrexx installation that is ready to roll and contains all pages, options, ... that have already been setup.
Maybe in the future a standard dump will be prepared containing the most usually used contents, so everybody can be working on the same base install.
As it stands now only one person at a time should be entering content into the CMS. When that person is finished he should dump the database and commit the new dump. Before starting to work on content one should always pull in the latest database dump and import it to one's developer database so contents are always up to date. Be very careful not to lose any content!
This system could also be optimized by using a central db on a server for development to which everybody has access.
