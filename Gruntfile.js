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
            "css/bootstrap-datepicker.css": "bootstrap-datepicker/dist/css/bootstrap-datepicker.css",
            "css/fileinput.css" : "bootstrap-fileinput/css/fileinput.css"
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
              "js/angular-strap.tpl.js": "angular-strap/dist/angular-strap.tpl.js",
              "js/fileinput.js" : "bootstrap-fileinput/js/fileinput.js"
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
    // Concatenar y minimizar archivos css
      cssmin: {
          stylesheets: {
              files: {
                  // Css screen contiene bootstrap, y la declaración css
                  "src/DSFacyt/InfrastructureBundle/Resources/public/assets/DSFacyt/dist/css/screen.css": [
                      "src/DSFacyt/InfrastructureBundle/Resources/public/assets/DSFacyt/stylesheets/screen.css"
                  ],
                  // Css de angular
                  "src/DSFacyt/InfrastructureBundle/Resources/public/assets/DSFacyt/dist/css/angular.css": [
                      "src/DSFacyt/InfrastructureBundle/Resources/public/assets/vendor/css/angular-motion.css",
                  ],
                  // Css de template del panel del usuario
                  "src/DSFacyt/InfrastructureBundle/Resources/public/assets/DSFacyt/dist/css/template-panel.css": [
                      "src/DSFacyt/InfrastructureBundle/Resources/public/assets/vendor/css/metisMenu/*.css",
                      "src/DSFacyt/InfrastructureBundle/Resources/public/assets/vendor/css/startbootstrap-sb-admin-2/*.css"
                  ],
                  // Css del datePicker
                  "src/DSFacyt/InfrastructureBundle/Resources/public/assets/DSFacyt/dist/css/datepicker.css": [
                      "src/DSFacyt/InfrastructureBundle/Resources/public/assets/vendor/css/bootstrap-datepicker.css"
                  ]
              }
          }
      },
      // Concatenar y minimizar archivos js
      uglify: {
          options: {
              // Esta opcion es para cambiar los nombres de funciones y
              // variables por letras y palabras cortas. Dejar opcion en falso.
              mangle: false
          },
          scripts: {
              files: {
                  //Js Bases
                  "src/DSFacyt/InfrastructureBundle/Resources/public/assets/DSFacyt/dist/js/scripts.js": [
                      // Archivos bases
                      "src/DSFacyt/InfrastructureBundle/Resources/public/assets/vendor/js/jquery.min.js",
                      "src/Navicu/InfrastructureBundle/Resources/public/assets/vendor/js/bootstrap.min.js",
                      "src/DSFacyt/InfrastructureBundle/Resources/public/assets/vendor/js/angular.js",
                      "src/DSFacyt/InfrastructureBundle/Resources/public/assets/vendor/js/angular-repeat-n.js"

                  ],
                  // Js de angular-strap
                  "src/DSFacyt/InfrastructureBundle/Resources/public/assets/DSFacyt/dist/js/angular-strap.js": [
                      "src/DSFacyt/InfrastructureBundle/Resources/public/assets/vendor/js/angular-strap.js",
                      "src/DSFacyt/InfrastructureBundle/Resources/public/assets/vendor/js/angular-strap.tpl.js"
                  ],
                  //Js del template del Panel
                  "src/DSFacyt/InfrastructureBundle/Resources/public/assets/DSFacyt/dist/js/template-panel.js": [
                      "src/DSFacyt/InfrastructureBundle/Resources/public/assets/vendor/js/metisMenu.js",
                      "src/DSFacyt/InfrastructureBundle/Resources/public/assets/vendor/js/sb-admin-2.js"
                  ],
                  //Js del template del Panel
                  "src/DSFacyt/InfrastructureBundle/Resources/public/assets/DSFacyt/dist/js/bootstrap-datepicker.js": [
                      "src/DSFacyt/InfrastructureBundle/Resources/public/assets/vendor/js/bootstrap-datepicker.js",
                      "src/DSFacyt/InfrastructureBundle/Resources/public/assets/vendor/js/bootstrap-datepicker.es.min.js"
                  ],
                  //Js: funcionalidades de las publicaciones tipo Texto
                  "src/DSFacyt/InfrastructureBundle/Resources/public/assets/DSFacyt/dist/js/app-panel-text.js": [
                      "src/DSFacyt/InfrastructureBundle/Resources/public/assets/DSFacyt/angular/Text/textModule.js",
                      "src/DSFacyt/InfrastructureBundle/Resources/public/assets/DSFacyt/angular/Text/textService.js",
                      "src/DSFacyt/InfrastructureBundle/Resources/public/assets/DSFacyt/angular/Text/textController.js"
                  ]
              }
          }
      }

  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks("grunt-bowercopy");
  grunt.loadNpmTasks("grunt-contrib-cssmin");
  grunt.loadNpmTasks("grunt-contrib-uglify");


  // Default task.
  grunt.registerTask("default", ["bowercopy"]);
  grunt.registerTask("prod", ["cssmin", "uglify"]);

};
