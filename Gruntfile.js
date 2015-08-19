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
      scripts: {
          files: {
              "js/bootstrap.js": "bootstrap-sass-official/assets/javascripts/bootstrap.js",
              "js/jquery.js": "jquery/dist/jquery.js",
              "js/sb-admin-2.js":"startbootstrap-sb-admin-2/dist/js/sb-admin-2.js",
              "js/metisMenu.js": "metisMenu/dist/metisMenu.js"
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
