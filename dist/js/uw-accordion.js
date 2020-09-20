/*
  UWAccordion
  v1.0.0
  A simple accordion for UW Theme based on https://github.com/stuartjnelson/badger-accordion by Osvaldas Valutis, www.osvaldas.info
*/

// NodeList.forEach polyfill
if (window.NodeList && !NodeList.prototype.forEach) {
  NodeList.prototype.forEach = Array.prototype.forEach;
}


(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
  typeof define === 'function' && define.amd ? define(factory) :
  (global.UWAccordion = factory());
}(this, (function () {
  'use strict';

  function _classCallCheck(instance, Constructor) {
    if (!(instance instanceof Constructor)) {
      throw new TypeError("Cannot call a class as a function");
    }
  }

  function _defineProperties(target, props) {
    for (var i = 0; i < props.length; i++) {
      var descriptor = props[i];
      descriptor.enumerable = descriptor.enumerable || false;
      descriptor.configurable = true;
      if ("value" in descriptor) descriptor.writable = true;
      Object.defineProperty(target, descriptor.key, descriptor);
    }
  }

  function _createClass(Constructor, protoProps, staticProps) {
    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
    if (staticProps) _defineProperties(Constructor, staticProps);
    return Constructor;
  }

  function _extends() {
    _extends = Object.assign || function (target) {
      for (var i = 1; i < arguments.length; i++) {
        var source = arguments[i];

        for (var key in source) {
          if (Object.prototype.hasOwnProperty.call(source, key)) {
            target[key] = source[key];
          }
        }
      }

      return target;
    };

    return _extends.apply(this, arguments);
  }



  /* eslint-disable no-unused-vars */
  (function (document, window) {
    var el = document.body || document.documentElement,
        s = el.style,
        prefixAnimation = '',
        prefixTransition = '';
    if (s.WebkitAnimation == '') prefixAnimation = '-webkit-';
    if (s.MozAnimation == '') prefixAnimation = '-moz-';
    if (s.OAnimation == '') prefixAnimation = '-o-';
    if (s.WebkitTransition == '') prefixTransition = '-webkit-';
    if (s.MozTransition == '') prefixTransition = '-moz-';
    if (s.OTransition == '') prefixTransition = '-o-';
    Object.defineProperty(Object.prototype, 'onCSSTransitionEnd', {
      value: function value(callback) {
        var runOnce = function runOnce(e) {
          callback();
          e.target.removeEventListener(e.type, runOnce);
        };

        this.addEventListener('webkitTransitionEnd', runOnce);
        this.addEventListener('mozTransitionEnd', runOnce);
        this.addEventListener('oTransitionEnd', runOnce);
        this.addEventListener('transitionend', runOnce);
        if (prefixTransition == '' && !('transition' in s) || getComputedStyle(this)[prefixTransition + 'transition-duration'] == '0s') callback();
        return this;
      },
      enumerable: false,
      writable: true
    });
  })(document, window, 0);

  /**
   *  ACCORDION
   *
   * Initializes the object
   */

  var UWAccordion =
  function () {
    function UWAccordion(el, options) {
      var instance = this;

      _classCallCheck(this, UWAccordion);

      var container = typeof el === 'string' ? document.querySelector(el) : el;

      // If el is not defined
      if (container == null) {
        return;
      }

      // Options
      var defaults = {
        headerClass: '.uw-accordion-header',
        panelClass: '.uw-accordion-panel',
        panelInnerClass: '.uw-accordion-panel-inner',
        hiddenClass: '-uw-accordion-is-hidden',
        activeClass: '-uw-accordion-is-active',
        initializedClass: 'uw-accordion--initialized'
      };

      this.settings = _extends({}, defaults, options);

      this.container = container;

      // create the button elements with SVG icons
      var headers = container.querySelectorAll(this.settings.headerClass);

      headers.forEach(function (header, index) {
        header.classList.remove(instance.settings.headerClass.substr(1));
        var panelButton = document.createElement('button');
        var panelButtonText = header.textContent;

        var svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
        svg.setAttribute("viewBox", "0 0 10 10");
        svg.setAttribute("focusable", "false");
        svg.setAttribute("aria-hidden", "true");

        var rect1 = document.createElementNS("http://www.w3.org/2000/svg", "rect");
        rect1.setAttribute("class", "vert");
        rect1.setAttribute("width", "2");
        rect1.setAttribute("height", "8");
        rect1.setAttribute("y", "1");
        rect1.setAttribute("x", "4");
        svg.appendChild(rect1);

        var rect2 = document.createElementNS("http://www.w3.org/2000/svg", "rect");
        rect2.setAttribute("width", "8");
        rect2.setAttribute("height", "2");
        rect2.setAttribute("y", "4");
        rect2.setAttribute("x", "1");
        svg.appendChild(rect2);

        header.innerHTML = '';
        panelButton.classList.add(instance.settings.headerClass.substr(1));
        panelButton.setAttribute('type', 'button');
        panelButton.setAttribute('aria-expanded', 'false');
        panelButton.appendChild(svg);
        panelButton.appendChild(document.createTextNode(panelButtonText));
        header.appendChild(panelButton);
      });

      // get the accordion header buttons
      this.headers = this.container.querySelectorAll(instance.settings.headerClass);

      // get the accordion panels
      this.panels = this.container.querySelectorAll(instance.settings.panelClass);

      this.panels.forEach(function(panel) {
        panel.setAttribute("aria-hidden", "true");
      });

      // Manage state of the accordion. Default to all panels closed
      this.states = [].map.call(this.headers, function () {
        return {
          state: 'closed'
        };
      });

      // generate id attributes for use with aria-labelledby
      this.ids = [].map.call(this.headers, function () {
        return {
          id: Math.floor(Math.random() * 1000000 + 1)
        };
      });

      // Initiating the accordion
      if (this.container) {
        this.init();
      } else {
        console.log('Something is wrong with your markup...');
      }
    }

    /**
     *  INIT
     *
     *  Initalises the accordion
     */
    _createClass(UWAccordion, [{
      key: "init",
      value: function init() {
        // Sets up ID, aria attrs & data-attrs
        this._setupAttributes();

        // Adding listeners to headers
        this._addListeners();

        // Adds class to accordion for initalisation
        this._finishInitialization();
      }
    },

    /**
     *  FINISH INITIALISATION
     *
     *  Adds in `initializedClass` to accordion
     */
    {
      key: "_finishInitialization",
      value: function _finishInitialization() {
        this.container.classList.add(this.settings.initializedClass);
      }
    },

    /**
     *  ADD LISTENERS
     *
     *  Adds click event to each header
     */
    {
      key: "_addListeners",
      value: function _addListeners() {
        var instance = this;

        this.headers.forEach(function (header, index) {
          header.addEventListener('click', function () {
            instance.handleClick(header, index);
          });
        });
      }
    },

    /**
     *  HANDLE CLICK
     *
     *  Handles click and checks if click was on an header element
     *  @param {object} targetHeader - The header node you want to open
     */
    {
      key: "handleClick",
      value: function handleClick(targetHeader, headerIndex) {

        // Update accordion panel states
        this.setState(headerIndex);

        this._renderDom();

      }
    },

    /**
     *  SET STATES
     *
     *  Sets the state for  headers.
     *  The 'target header' will have its state toggled
     *  @param {int} targetHeaderId - The header node you want to open
     */
    {
      key: "setState",
      value: function setState(targetHeaderId) {
        var instance = this;

        var states = this.getState();

        // Toggles the state value of the target header.
        states.filter(function (state, index) {
          if (index === targetHeaderId) {
            var newState = instance.toggleState(state.state);
            return state.state = newState;
          }
        });

      }
    },

    /**
     *  RENDER DOM
     *
     *  Renders the accordion in the DOM based on current accordion state
     */
    {
      key: "_renderDom",
      value: function _renderDom() {
        var instance = this;

        // Filter through all open headers and open them
        this.states.filter(function (state, index) {
          if (state.state === 'open') {
            instance.open(index);
          }
        });

        // Filter through all closed headers and closes them
        this.states.filter(function (state, index) {
          if (state.state === 'closed') {
            instance.close(index);
          }
        });
      }
    },

    /**
     *  OPEN
     *
     *  Opens a specific panel
     *  @param {integer} headerIndex - The header node index you want to open
     */
    {
      key: "open",
      value: function open(headerIndex) {
        this.togglePanel('open', headerIndex);
      }
    },

    /**
     *  CLOSE
     *
     *  Closes a specific panel
     *  @param {integer} headerIndex - The header node index you want to close
     */
    {
      key: "close",
      value: function close(headerIndex) {
        this.togglePanel('closed', headerIndex);
      }
    },

    /**
     *  OPEN ALL
     *
     *  Opens all panels
     */
    {
      key: "openAll",
      value: function openAll() {
        var instance = this;

        this.states.filter(function (state, index) {
          return state.state = 'open';
        });

        this.headers.forEach(function (header, headerIndex) {
          instance.togglePanel('open', headerIndex);
        });
      }
    },

    /**
     *  CLOSE ALL
     *
     *  Closes all panels
     */
    {
      key: "closeAll",
      value: function closeAll() {
        var instance = this;

        this.states.filter(function (state, index) {
          return state.state = 'closed';
        });

        this.headers.forEach(function (header, headerIndex) {
          instance.togglePanel('closed', headerIndex);
        });
      }
    },

    /**
     *  TOGGLE PANEL
     *
     *  Toggles a panel and set attrs on its panel and header
     *  @param {string} action - The animation you want to invoke
     *  @param {integer} headerIndex - The header node index you want to animate
     */
    {
      key: "togglePanel",
      value: function togglePanel(action, headerIndex) {

        if (action !== undefined && headerIndex !== undefined) {
          if (action === 'closed') {

            var header = this.headers[headerIndex];
            var panelToClose = this.panels[headerIndex];

              panelToClose.classList.add(this.settings.hiddenClass);
              panelToClose.setAttribute('aria-hidden', 'true');
              panelToClose.classList.remove(this.settings.activeClass);

              header.classList.remove(this.settings.activeClass);
              header.setAttribute('aria-expanded', false);

          } else if (action === 'open') {

            var header = this.headers[headerIndex];
            var panelToOpen = this.panels[headerIndex];

            this.calculatePanelHeight(panelToOpen);
            panelToOpen.classList.remove(this.settings.hiddenClass);
            panelToOpen.setAttribute('aria-hidden', 'false');
            panelToOpen.classList.add(this.settings.activeClass);

            header.classList.add(this.settings.activeClass);
            header.setAttribute('aria-expanded', true);

          }

          // fire the panel-toggle event
          var event = document.createEvent('Event');
          event.initEvent('panel-toggle', true, true);
          this.container.dispatchEvent(event);
        }
      }
    },

    /**
     *  GET STATE
     *
     *  Getting state of headers.
     */
    {
      key: "getState",
      value: function getState() {
        return this.states;
      }
    },

    /**
     *  TOGGLE STATE
     *
     *  Toggling the state value
     *  @param {string} currentState - Current state value for a header
     */
    {
      key: "toggleState",
      value: function toggleState(currentState) {
        return currentState === 'closed' ? 'open' : 'closed';
      }
    },

    /**
     *  SET UP ATTRIBUTES
     *
     *  Initalises accordion attribute methods
     */
    {
      key: "_setupAttributes",
      value: function _setupAttributes() {
        // Adding ID & aria-controls
        this._setupHeaders();

        // Adding ID & aria-labelledby
        this._setupPanels();
      }

    },

    /**
     *  CALCULATE PANEL HEIGHT
     *
     *  Setting height for panels using panels inner element
     */
    {
      key: "calculatePanelHeight",
      value: function calculatePanelHeight(panel) {
        var panelInner = panel.querySelector(this.settings.panelInnerClass);
        var activeHeight = panelInner.offsetHeight;

        // add buffer
        activeHeight = activeHeight + 28;
        return panel.style.maxHeight = "".concat(activeHeight, "px");
      }
    },

    /**
     *  CALCULATE OPEN PANEL HEIGHT
     *
     *  Setting height for panels using panels inner element
     */
    {
      key: "calculateOpenPanelsHeight",
      value: function calculateOpenPanelsHeight() {
        var instance = this;
        var states = this.getState();

        this.panels.forEach(function (panel, index) {
          if (states[index].state === 'open') {
            instance.calculatePanelHeight(panel);
          }
        });
      }
    },

    /**
     * SET UP HEADERS
     */
    {
      key: "_setupHeaders",
      value: function _setupHeaders() {
        var instance = this;

        this.headers.forEach(function (header, index) {
          header.setAttribute('id', "uw-accordion-header-".concat(instance.ids[index].id));
          header.setAttribute('aria-controls', "uw-accordion-panel-".concat(instance.ids[index].id));
        });
      }
    },

    /**
     * SET UP PANELS
     */
    {
      key: "_setupPanels",
      value: function _setupPanels() {
        var instance = this;

        this.panels.forEach(function (panel, index) {
          panel.setAttribute('id', "uw-accordion-panel-".concat(instance.ids[index].id));
          panel.setAttribute('aria-labelledby', "uw-accordion-header-".concat(instance.ids[index].id));
        });
      }
    }]);

    return UWAccordion;
  }();

  return UWAccordion;

})));
