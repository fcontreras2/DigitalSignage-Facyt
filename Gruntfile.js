/*global module:false*/
module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    // Metadata.
    pkg: grunt.file.readJSON('package.json'),
    bowercopy: {
      options: {
        srcPrefix: 'bower_components',
        destPrefix: "src/DSFacyt/InfrastructureBundle/Resources/public/assets/vendor",
        runBower: false
      },
      stylesheets: {
        files: {
            "css/angular-motion.css": "angular-motion/dist/angular-motion.css",
            "css/bootstrap-datepicker.css": "bootstrap-datepicker/dist/css/bootstrap-datepicker.css"
        }
      },
      scripts: {
          files: {
              "js/angular.js": "angular/angular.js",
              "js/angular-repeat-n.js": "angular-repeat-n/dist/angular-repeat-n.js",
              "js/bootstrap.js": "bootstrap-sass-official/assets/javascripts/bootstrap.js",
              "js/jquery.js": "jquery/dist/jquery.js",
              "js/sb-admin-2.js":"startbootstrap-sb-admin-2/dist/js/sb-admin-2.js",
              "js/bootstrap-datepicker.js": "bootstrap-datepicker/dist/js/bootstrap-datepicker.js",
              "js/bootstrap-datepicker.es.min.js": "bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js",
              "js/metisMenu.js": "metisMenu/dist/metisMenu.js",
              "js/angular-strap.js": "angular-strap/dist/angular-strap.js",
              "js/angular-strap.tpl.js": "angular-strap/dist/angular-strap.tpl.js"
          }
      },      
      folders: {
          files: {
              "sass/bootstrap-sass-official": "bootstrap-sass-official/assets/stylesheets/*",
              "css/startbootstrap-sb-admin-2": "startbootstrap-sb-admin-2/dist/css/*",
              "css/metisMenu":"metisMenu/dist/metisMenu.css",
              "sass/font-awesome-sass": "font-awesome/scss/*"                            
          }
      }
    },

  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks("grunt-bowercopy");
  grunt.loadNpmTasks("grunt-contrib-cssmin");
  grunt.loadNpmTasks("grunt-contrib-uglify");


  // Default task.
  grunt.registerTask("default", ["bowercopy"]);
  grunt.registerTask("prod", ["cssmin", "uglify"]);

};
