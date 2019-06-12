###*
  * Your JS/CoffeeScript goes here
  * Components like custom classes are in components/
  * Third party libraries are in vendor/ or /bower_components/
  *
  * For CoffeeScript style guide please refer to
  * https://github.com/RTO-Websites/CoffeeScript-Style-Guide
  *
  * @since 0.1.0
  * @author RTO GmbH <info@rto.de>
  * @license MIT
###
'use strict'

jQuery ($) ->

  $window = $(window)
  $document = $(document)

  ###
    * Initialize modules/plugins/etc.
    *
    * @since 0.1.0
    * @return {void}
  ###
  init = ->
    return

  ###
    * Register listeners to all kind of events.
    *
    * @since 0.1.0
    * @return {void}
  ###
  registerEventListeners = ->
    $window.on('load', onWindowLoad)
    return

  ###
    * Fix bug in lightbox swiping.
    *
    * @since 0.1.0
    * @return {void}
  ###
  onWindowLoad = (event) ->
    if typeof Swiper is 'function'
      Swiper.defaults.noSwipingClass = 'elementor-swiper-button'
  return

  init()
  registerEventListeners()
