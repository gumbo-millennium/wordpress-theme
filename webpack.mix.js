const mix = require('laravel-mix')
const StyleLintPlugin = require('stylelint-webpack-plugin')
const wrapAnsi = require('wrap-ansi')

// Configure javascript
mix.js('assets/js/admin.js', 'dist/admin.js')

// Configure SCSS for admin panel and WordPress
mix
  .sass('assets/scss/admin.scss', 'dist/admin.css')
  .sass('assets/scss/editor.scss', 'dist/editor.css')
  .sass('assets/scss/theme.scss', './style.css')

// Add source maps if not in production
if (!mix.inProduction()) {
  mix.sourceMaps()
}

// Linters
mix.webpackConfig({
  module: {
    rules: [
      {
        enforce: 'pre',
        test: /assets\/js\/.+\.js$/,
        loader: 'eslint-loader',
        options: {
          cache: true
        }
      }
    ]
  },
  plugins: [
    new StyleLintPlugin({
      files: [
        'assets/scss/**/*.s?(a|c)ss'
      ]
    })
  ]
})

// Banner
mix.webpackConfig(webpack => {
  const description = [
    'Description:',
    'Het thema voor de Gumbo Millennium website. Dit thema levert de vereiste menu\'s',
    'en widgets aan voor integratie met Corcel en de front-end website. Dit thema bevat ',
    'geen daadwerkelijk thema en zal een foutmelding tonen indien de website verkeerd is',
    'geconfigureerd.'
  ].join(' ')

  const banner = [
    'Theme Name: Gumbo Millennium',
    'Theme URI: https://www.gumbo-millennium.nl/',
    'Author: Digitale Commissie',
    'Author URI: https://www.gumbo-millennium.nl/commissions/dc',
    'Version: 1.0',
    'License: Mozilla Public License v2.0',
    'License URI: https://www.mozilla.org/en-US/MPL/2.0/',
    'Tags: custom-made, corcel-integration, gumbo-millennium, mpl-2, private-use, non-commercial, financed-by-DUO',
    '',
    wrapAnsi(description, 80, {
      hard: true,
      wordWrap: true
    })
  ].join('\n')

  return {
    plugins: [
      // Banners
      new webpack.BannerPlugin({
        test: /(style|theme)\.css$/,
        banner: banner
      })
    ]
  }
})
