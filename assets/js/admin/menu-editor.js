/**
 * Handles the menu editor's changes. Shows a warning when the menus are nesting too deeply.
 *
 * @author Roelof Roos <github@roelof.io>
 * @license MPL-2.0
 */

import debounce from 'debounce'

// Constant grouped stuff
const selectors = {
  menuEditor: '#menu-to-edit',
  deepMenu: '.menu-item-depth-',
  locationCheckboxes: '.menu-theme-locations input'
}
const menuNames = [
  ['header', 2],
  ['footer', 1],
  ['footer-legal', 1]
]
const passiveEvent = {
  passive: true,
  capture: false
}
const events = {
  menu: ['drop', 'dragend', 'mouseup', 'touchend'],
  document: ['menu-item-added', 'menu-removing-item']
}

let currentMaxDepth = 99

/**
 * Updates the style of the menu editor if there are invalid nodes
 */
const updateBodyStyle = () => {
  if (currentMaxDepth === 99) {
    return
  }
  // Find the menu, again
  let menu = document.querySelector(selectors.menuEditor)
  let selector = selectors.deepMenu + currentMaxDepth

  // Enable or disable the class
  menu.classList.toggle('menu--has-overflow', menu.querySelector(selector) !== null)
}

/**
 * Binds to any possible drag, drop or change event
 */
const bindMenuListener = () => {
  // Listen to DOM changes
  let menu = document.querySelector(selectors.menuEditor)

  let callback = debounce(updateBodyStyle, 50)
  events.menu.forEach(event => {
    menu.addEventListener(event, callback, passiveEvent)
  })
  events.document.forEach(event => {
    document.addEventListener(event, callback, passiveEvent)
  })
}

/**
 * Checks all checkboxes for menu locations that might need a warning
 */
const toggleMenuLocationClass = () => {
  let menu = document.querySelector(selectors.menuEditor)
  currentMaxDepth = 99
  menuNames.forEach(item => {
    let name = item[0]
    let depth = item[1]

    let checked = document.querySelector(`${selectors.locationCheckboxes}#locations-${name}`).checked

    if (checked) {
      menu.classList.add(`menu--has-${name}`)
      currentMaxDepth = Math.min(currentMaxDepth, depth)
    } else {
      menu.classList.remove(`menu--has-${name}`)
    }
  })
  updateBodyStyle()
}

/**
 * Binds checkbox events so the CSS class of the menu picker is updated accordingly
 */
const bindMenuLocationCheckboxes = () => {
  document.querySelectorAll(selectors.locationCheckboxes).forEach(node => {
    node.addEventListener('change', toggleMenuLocationClass, passiveEvent)
  })
  toggleMenuLocationClass()
}

/**
* Binds an alert to the menu editor, showing it if the menu becomes > 2 nodes deep
*/
export default () => {
  if (document.querySelector(selectors.menuEditor) === null) {
    return
  }

  bindMenuListener()
  bindMenuLocationCheckboxes()
}
