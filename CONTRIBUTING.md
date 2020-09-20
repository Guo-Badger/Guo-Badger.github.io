Found/fixed a bug? Interested in submitting a new feature? We know this campus is rich with web talent and we hope you will join us in our efforts to continually improve this theme. Here are a few ways to contribute:

## Submitting Code
In a nutshell, here are the steps for contributing (see below for detailed instructions):
1. Fork the project
2. Clone the project to work locally
3. Push your changes to your fork
4. Submit your changes as a Merge Request. New features will be reviewed for brand standards and User Experience implications. All new additions to the theme must also meet certain quality standards (accessibility, browser compatibility, PHP version compatibility).
6. Once your Merge Request is approved, we will merge it in.

<strong>Detailed instructions:</strong>

The following steps assume that you know git and the commands needed to pull, commit and push to remote repositories. Please review the [Git](https://git-scm.com/docs/gittutorial) documentation if you're not familiar with Git.
1. Getting started with the project
	* Navigate to the Master Repository: https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme
    * Create a fork of the Master and associate it with your user account
    * Clone your forked repo to your local machine by navigating to the location you'd like to download it to (using command prompt or a terminal app)
2. Running the project locally
    * See the [README](README.md) for details on building a local development environment for the theme
3. Contributing to the project
    * If this is not the first time working with this repo, make sure to sync your fork from the Dev branch before starting to work. 
    * Create a branch that either describes the feature being developed or directly ties to a Jira issue
    * Commit changes to the created branch early and often
    * When development is finished and ready be merged, push your branch to your fork and open a merge request.
4. The art of review
    * Login to GitLabs
    * Generate merge request
    * Gather feedback and make edits as needed/requested
    * Once your code is approved, someone from the University Marketing or DoIT team will merge your pull request into master

### Git Workflow
All new code should be submitted to the Dev branch (the master branch is reserved for releases). Learn more about the workflow we are following here: https://www.atlassian.com/git/tutorials/comparing-workflows#gitflow-workflow.

### Working with ACF JSON
The theme comes pre-packaged with Advanced Custom Fields and the standard page uses ACF heavily to populate all the page elements. The theme is set to use ACF JSON so all field groups remain in sync and all new changes are added to the theme automatically. Read more here: https://www.advancedcustomfields.com/resources/local-json/

<strong>Edit Custom Field groups with extreme caution</strong> We encourage you to get in touch with us if you have questions or concerns about working with editing Field Groups. If you are planning to edit any Custom Field Groups, there are a few steps to take to ensure that you remain in sync:

1. Sync any field groups.
    * In the WordPress admin area, click on 'Custom Fields' (usually towards the bottom of the menu bar)
    * If you see any field groups with a circular icon with arrows inside, that means that field group needs to be synced
    * Click on 'Sync Available'
    * Hover over the field name and you will see the word 'Sync' appear. Click on 'sync' to update the field group
2. Make your field changes
    * You can make changes in the WordPress admin area or by editing the corresponding acf-json file.
    ** NOTE: if you edit the .json file directly, be sure to update the Unix timestamp at the very bottom of the file with the current time (find the current Unix time here: https://www.unixtimestamp.com/)
    * All "key" values must be unique. Adding fields within the WordPress admin will generate custom keys. If you work with the .json file, be sure to manually change all key values to be unique.
3. Commit your changes and check carefully for merge conflicts
    * Merge conflicts in the acf-json files can be hairy. Proceed with caution and please carefully check that you aren't overwriting any exisitng fields.


## Report Issues, Submit Comments, Request Features
Whether you have resources to submit code or not, we welcome all feedback.

## Connect
The UW WordPress Group is an effort to create a common place for WordPress users and developers on campus to ask questions and share their experiences with the platform.

<strong>Join the Mailing List</strong>
To join the group mailing list, send an email to join-uwwordpress@lists.wisc.edu.

To unsubscribe, send an email to leave-uwwordpress@lists.wisc.edu.

<strong>Contact Us</strong>
Email wordpress@umark.wisc.edu if you have questions about the group or the official UW–Madison WordPress theme.
