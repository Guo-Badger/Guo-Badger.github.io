## UW Theme

### Getting Started

#### Prerequisites

This project consists of a WordPress theme only. If you want to contribute to the creation of this theme you will have to create your own local WordPress development environment and then add the theme.

There are a number of ways to do this. WordPress requires: PHP, MySQL, and a server usually Apache or nginx (PHP’s built-in server also works). Luckily there are tools that have been created to help create a specific development environment for WordPress. Here are a few suggestions on tools that will help you setup a local WordPress environment:

* MAMP - [https://www.mamp.info/en/](https://www.mamp.info/en/) or WAMP (if on windows) - [http://www.wampserver.com/en/](http://www.wampserver.com/en/)
* Docker  - [https://www.docker.com/](https://www.docker.com/) Try the [WordPress Docker Development Environment](https://github.com/10up/wp-local-docker)
* VVV (Varying Vagrant Vagrants) - [https://github.com/Varying-Vagrant-Vagrants/VVV](https://github.com/Varying-Vagrant-Vagrants/VVV)
* Other tool of your choosing

If you don't know which one to choose, we recommend starting with the first option. This will give you a better idea of how all the various parts are working together. The other two options create virtual workspaces to abstract these pieces and may require additional know-how to work with them.

#### Setting it up

You need Git to clone the repository. You can get Git from
[https://git-scm.com/](https://git-scm.com/).

We also use a number of node.js tools to initialize the project. You must have node.js and its package manager (npm) installed.  You can get them from [http://nodejs.org/](http://nodejs.org/).

Have a look at the [Contribution guide](CONTRIBUTING.md) to learn how to best contribute.

Navigate to the `wordpress/wp-content/theme` directory and clone the repository.

(The theme also supports using PHP's Composer dependency manager for installing the theme if you use Composer. You'll need to add the project repo URL as a Composer repository.)

Enable [debug mode](https://codex.wordpress.org/Debugging_in_WordPress) in your `wp-config.php` file.

Ensure you have built the project assets (see below) before activating the theme.

#### Building the project assets
Once npm is installed type `npm install` from the project directory. After the install is complete it will build the CSS and bundle the JavaScript.

At anytime you can manually build the project assets by typing `npm run build`

Other helpful npm commands:
`npm run build-css` - compiles the sass files to css and outputs them to `/dist/main.css`
`npm run watch-css` - watches the sass files for changes and recompiles the sass files
`npm run build-js` - builds the javascript bundle and outputs the results to `/dist/main.js`

`npm run build-prod` - minifies, uglifies project assets for production to `/dist/`. Set WP_DEBUG flag to false to use the production assets.

#### Setting up browser sync
Edit the `/.bin/dev-url` file and replace the url in the file with your local WordPress url. (This file is ignored by the repo so don't worry about committing changes.)

Then run `npm run dev` which will watch the sass files for changes and build the css and reload the browser. Currently it's setup to use Chrome as your browser of choice but can be configured to use other browsers. [See how](https://www.browsersync.io/docs/)

#### Foundation 6
This theme uses a custom version of [Foundation](http://foundation.zurb.com/), the responsive framework. When making changes to the foundation theme do so in the `_settings.scss` file located in `assets/styles` The settings file is for any specific changes to the framework itself including: variables, media queries, component styles etc. Before adding custom styles see what's possible within the settings file first.

The theme uses a subset of Foundation components. The current included components are found in the `assets/styles/foundation.scss` file.

The theme also includes a collection of UW- and theme-specific components, with corresponding Sass files. Any other custom styles that fall outside of the Foundation packaged components and the theme- and UW-specific components, should be added to the `assets/styles/custom.scss` file.

To update Foundation in local development (e.g. after a version update), use `npm update foundation-sites`

### Contributing

See the [Contribution Guide](CONTRIBUTING.md) to learn how to contribute fixes and features to the project.

### Theme Templates, Short Codes and Filter Hooks

Useful notes to read when developing child themes for the UW Theme

* [Theme partial templates](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/wikis/partial-templates)
* [Action Hook Page Builder Element](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/wikis/action-hook-page-element)
* [Short codes](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/wikis/short-codes)
* [Filter hooks](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/wikis/filter-hooks)

### Accessibility
See the [Accessibility Guide](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/wikis/accessibility) to learn about the theme's Accessibility standards and decision points in the building of this theme.

### Releasing new theme versions
See the [Preparing a new release guide](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/wikis/Preparing-a-new-release) to learn how to prepare the UW Theme for a new version release.

### Changes
See the [CHANGELOG](CHANGELOG.md) for details about what changes with each release.
