var Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */
    .addEntry('core', './assets/core.js')
    .addEntry('app', './assets/js/app.js')
    .addEntry('admin', './assets/admin/admin.js')
    .addEntry('match_details', './assets/admin/match/match_details.js')
    .addEntry('player', './assets/admin/player/player.js')
    .addEntry('team', './assets/admin/team/team.js')
    .addEntry('news', './assets/admin/news/news.js')
    .addEntry('league', './assets/admin/league/league.js')
    .addEntry('season', './assets/admin/season/season.js')
    .addEntry('datetimepicker', './assets/admin/datetimepicker.js')
    .addEntry('datepicker', './assets/admin/datepicker.js')
    .addEntry('player_datepicker', './assets/admin/player/player_datepicker.js')
    .addEntry('prevent_multiple_js_loading', './assets/admin/player/prevent_multiple_js_loading.js')
    .addEntry('admin_menu', './assets/admin/menu.js')
    .addEntry('main', './assets/js/theme-main.js')
    .addEntry('scripts', './assets/js/theme-scripts.js')
    .addEntry('login_page', './assets/css/login_page.css')
    // .addEntry('semantic_styles', './semantic/out/semantic.min.css')
    // .addEntry('semantic_javascripts', './semantic/out/semantic.min.js')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()
    // .disableSingleRuntimeChunk()
    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
    .configureBabel(() => {}, {
        useBuiltIns: 'usage',
        corejs: 3
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()
    .copyFiles({
        from: './assets/img',
        to: '/img/[path][name].[ext]'
    })
    .copyFiles({
        from: './assets/admin/tinymce/skins',
        to: '/skins/[path][name].[ext]'
    })
    // uncomment if you use API Platform Admin (composer req api-admin)
    //.enableReactPreset()
    //.addEntry('admin', './assets/js/admin.js')
;

module.exports = Encore.getWebpackConfig();
