module.exports = function(grunt) { 

    var requirejs   = grunt.config('requirejs') || {};
    var clean       = grunt.config('clean') || {};
    var copy        = grunt.config('copy') || {};

    var root        = grunt.option('root');
    var libs        = grunt.option('mainlibs');
    var ext         = require(root + '/tao/views/build/tasks/helpers/extensions')(grunt, root);
    var out         = 'output/wfAuthoring';

    /**
     * Remove bundled and bundling files
     */
    clean.taocebundle = [out,  root + '/wfAuthoring/views/js/controllers.min.js'];
    
    /**
     * Compile tao files into a bundle 
     */
    requirejs.taocebundle = {
        options: {
            baseUrl : '../js',
            dir : out,
            mainConfigFile : './config/requirejs.build.js',
            paths : { 'wfAuthoring' : root + '/wfAuthoring/views/js' },
            modules : [{
                name: 'wfAuthoring/controller/routes',
                include : ext.getExtensionsControllers(['wfAuthoring']),
                exclude : ['mathJax', 'mediaElement'].concat(libs)
            }]
        }
    };

    /**
     * copy the bundles to the right place
     */
    copy.taocebundle = {
        files: [
            { src: [out + '/wfAuthoring/controller/routes.js'],  dest: root + '/wfAuthoring/views/js/controllers.min.js' },
            { src: [out + '/wfAuthoring/controller/routes.js.map'],  dest: root + '/wfAuthoring/views/js/controllers.min.js.map' }
        ]
    };

    grunt.config('clean', clean);
    grunt.config('requirejs', requirejs);
    grunt.config('copy', copy);

    // bundle task
    grunt.registerTask('taocebundle', ['clean:taocebundle', 'requirejs:taocebundle', 'copy:taocebundle']);
};
