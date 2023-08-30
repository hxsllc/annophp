# annophp
IIIF annotation server application using PHP and MySQL

Created by: Human Experience Systems / Ben Bakelaar

Development: William Brown (Github @wpb119)

# Installation
This is a Laravel application. It is not like Wordpress, Drupal, or Omeka where you can download the ZIP file, upload it to your web host, and then install it.

1. Retrieve the files
2. Install the application
3. Create the database
4. Connect the database

To retrieve the files, run `git clone` to download the application. Alternatively, you can download as a ZIP, and upload it to your web host in the root or any sub-directory.

To install the application, run `composer install` from the directory with the application. You may run into issues with PHP compatibility. I was able to work around this on my webhost (reclaimhosting.com) by using the following command. This only worked because I could set the "domain PHP" to 8.1 in the MultiPHP Manager in cPanel.
`composer install --ignore-platform-reqs`

To create the database, go to `this wiki page` and run the SQL inside a MySQL database that you create on your webhost.

To connect the database to the application, create a .env file in the application directory which has `these settings`.
