/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************************!*\
  !*** ./resources/js/modalAjouterBouteilleIndex.js ***!
  \****************************************************/
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw new Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw new Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }
var bouteilleID;
// Sélectionner la fenêtre modale
var modal = document.getElementById('modal-ajouter');

// Fonction appelé par l'événement d'écouteur de clic à chaque bouton "+ Ajouter"
function onButtonClick(event) {
  // Empêcher le comportement par défaut du lien (qui est de naviguer vers une nouvelle page)
  event.preventDefault();
  bouteilleID = event.currentTarget.getAttribute('data-bouteille-id');

  // Ouvrir la fenêtre modale
  modal.showModal();
}

// Fonction appelé par l'événement d'écouteur de clic à chaque bouton fermer
function onButtonCloseClick(event) {
  // Empêcher le comportement par défaut du bouton (qui est de soumettre le formulaire)
  event.preventDefault();

  // Fermer la fenêtre modale
  modal.close();
}

// Fonction appelé par l'événement d'écouteur de clic sur la fenêtre
function onWindowsClick(event) {
  if (event.target === modal) {
    modal.close();
  }
}

// Récupérér les éléments dans la fenêtre modale
var form = document.querySelector('#form-ajouter');

//Récupérer les éléments de la fenêtre modale
var listRadio = document.querySelector('#location-liste');
var cellierRadio = document.querySelector('#location-cellier');
var selectLocation = document.querySelector('#select-location');
var labelLocation = document.querySelector('#label-location');
var selectListes = [];
var selectCelliers = [];
// Sélectionner le bouton "annuler" dans la fenêtre modale
var closeModalButton = document.querySelector('.btn-modal-cancel');
var url = '/celliers-json';
//Fonction appelé par l'événement d'écouteur de changement aux radios
function onListRadioChange(event) {
  url = '/listes-json';
  labelLocation.innerHTML = 'Choisir la liste';
  if (selectListes.length === 0) {
    loadOptions('liste');
  } else {
    selectLocation.innerHTML = "";
    selectListes.forEach(function (liste) {
      selectLocation.appendChild(liste);
    });
    if (selectLocation.querySelector('option').textContent == "Vous n'avez pas de liste") {
      form.querySelector('.btn-modal-action').innerHTML = "Créer une liste";
    } else {
      form.querySelector('.btn-modal-action').innerHTML = "ajouter";
    }
  }
}
function onCellierRadioChange(event) {
  url = '/celliers-json';
  labelLocation.innerHTML = 'Choisir le cellier';
  if (Object.keys(selectCelliers).length === 0) {
    loadOptions('cellier');
  } else {
    selectLocation.innerHTML = "";
    selectCelliers.forEach(function (cellier) {
      selectLocation.appendChild(cellier);
    });
    if (selectLocation.querySelector('option').textContent == "Vous n'avez pas de cellier") {
      form.querySelector('.btn-modal-action').innerHTML = "Créer un cellier";
    } else {
      form.querySelector('.btn-modal-action').innerHTML = "ajouter";
    }
  }
}
var windowLocation = window.location.toString();
if (windowLocation.includes('listes')) {
  url = '/listes-json';
  loadOptions('liste');
  listRadio.checked = true;
} else {
  url = '/celliers-json';
  loadOptions('cellier');
}

// Fonction pour charger les options (de celliers ou listes)
function loadOptions(_x) {
  return _loadOptions.apply(this, arguments);
} //Fonction appelé par l'événement d'écouteur de changement de l'envoi du formulaire
function _loadOptions() {
  _loadOptions = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2(type) {
    var response, data, cellier_id, cellierOrigine, liste_id, listeOrigine, optionElement;
    return _regeneratorRuntime().wrap(function _callee2$(_context2) {
      while (1) switch (_context2.prev = _context2.next) {
        case 0:
          _context2.prev = 0;
          _context2.next = 3;
          return fetch(url, {
            method: 'GET',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
          });
        case 3:
          response = _context2.sent;
          if (response.ok) {
            _context2.next = 6;
            break;
          }
          throw new Error('Network response was not ok');
        case 6:
          _context2.next = 8;
          return response.json();
        case 8:
          data = _context2.sent;
          selectLocation.innerHTML = '';
          if (data && data.length > 0) {
            data.forEach(function (option) {
              var optionElement = document.createElement('option');
              optionElement.value = option.id;
              optionElement.textContent = option.nom;
              selectLocation.appendChild(optionElement);
              if (type === "cellier") {
                selectCelliers.push(optionElement);
              } else {
                selectListes.push(optionElement);
              }
            });
            if (windowLocation.includes('celliers') && cellierRadio.checked) {
              //Trouver l'ID du cellier dans l'URL
              cellier_id = windowLocation.match(/\/celliers\/(\d+)\//)[1]; //Selectionner le cellier à partir duquel l'utilisateur est venu
              labelLocation.innerHTML = 'Choisir le cellier';
              cellierOrigine = selectLocation.querySelector('option[value="' + cellier_id + '"]');
              cellierOrigine.selected = 'selected';
              console.log(cellierOrigine);
            } else if (windowLocation.includes('listes') && listRadio.checked) {
              //Trouver l'ID du cellier dans l'URL
              liste_id = windowLocation.match(/\/listes\/(\d+)\//)[1];
              labelLocation.innerHTML = 'Choisir la liste';
              //Selectionner le cellier à partir duquel l'utilisateur est venu
              listeOrigine = selectLocation.querySelector('option[value="' + liste_id + '"]');
              listeOrigine.selected = 'selected';
            }
          } else {
            optionElement = document.createElement('option');
            optionElement.textContent = "Vous n'avez pas de " + type;
            selectLocation.appendChild(optionElement);
            if (type === 'cellier') {
              form.querySelector('.btn-modal-action').innerHTML = "Créer un cellier";
            } else if (type === 'liste') {
              form.querySelector('.btn-modal-action').innerHTML = "Créer une liste";
            }
            if (type === "cellier") {
              selectCelliers.push(optionElement);
            } else {
              selectListes.push(optionElement);
            }
          }
          _context2.next = 16;
          break;
        case 13:
          _context2.prev = 13;
          _context2.t0 = _context2["catch"](0);
          console.error('Error: ', _context2.t0);
        case 16:
        case "end":
          return _context2.stop();
      }
    }, _callee2, null, [[0, 13]]);
  }));
  return _loadOptions.apply(this, arguments);
}
function onFormSubmit(event) {
  event.preventDefault();
  console.log(form.querySelector('.btn-modal-action').textContent);
  if (form.querySelector('.btn-modal-action').textContent != "ajouter") {
    if (form.querySelector('.btn-modal-action').textContent == "Vous n'avez pas de liste") {
      //window.location.href = "/listes-ajouter"; 
    } else {
      //window.location.href = "/celliers-ajouter"; 
    }
  } else {
    var ajouterBouteille = /*#__PURE__*/function () {
      var _ref = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee(newQuantity, locationId, bouteilleId) {
        var response, data, toastLocation;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              _context.prev = 0;
              _context.next = 3;
              return fetch(url, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                  quantite: newQuantity,
                  location_id: locationId,
                  bouteille_id: bouteilleId
                })
              });
            case 3:
              response = _context.sent;
              if (response.ok) {
                _context.next = 6;
                break;
              }
              throw new Error('Network response was not ok');
            case 6:
              _context.next = 8;
              return response.json();
            case 8:
              data = _context.sent;
              console.log(data.message);
              console.log(url);
              if (url == '/celliers-json') {
                toastLocation = "celliers";
              } else {
                toastLocation = "listes";
              }

              // Ajouter le message au toast et l'afficher avec saut de nav-item
              afficherToastEtSauterNav(quantiteBouteille, toastLocation);
              modal.close();
              _context.next = 19;
              break;
            case 16:
              _context.prev = 16;
              _context.t0 = _context["catch"](0);
              console.error('Error: ', _context.t0);
            case 19:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[0, 16]]);
      }));
      return function ajouterBouteille(_x2, _x3, _x4) {
        return _ref.apply(this, arguments);
      };
    }();
    var quantiteBouteille = document.querySelector('#quantite-bouteille').value;
    var idLocation = document.querySelector('#select-location').value;
    ajouterBouteille(quantiteBouteille, idLocation, bouteilleID);
  }
}

// FONCTION pour message toast et animation sur nav-item
function afficherToastEtSauterNav(quantiteBouteille, toastLocation) {
  // Afficher le toast
  afficherToast("".concat(quantiteBouteille, " bouteille(s) ajout\xE9e(s) dans ").concat(toastLocation, "!"));
  modal.close();

  // Identifier l'élément de navigation à animer
  var navItemId = toastLocation === 'celliers' ? 'nav-celliers' : 'nav-listes';
  var navItem = document.getElementById(navItemId);

  // Appliquer l'animation
  navItem.classList.add('jump-animation');

  // Optionnel: retirer l'animation après qu'elle soit terminée
  setTimeout(function () {
    navItem.classList.remove('jump-animation');
  }, 500); // 500 ms correspond à la durée de l'animation
}

// FONCTION pour afficher le message toast
function afficherToast(message) {
  var snackbar = document.getElementById('snackbar');
  var messageElement = document.getElementById('snackbar-message');
  messageElement.textContent = message; // Mettre à jour le message seulement

  snackbar.className = 'show'; // Afficher le toast

  // Cacher le toast après 3 secondes
  setTimeout(function () {
    snackbar.className = snackbar.className.replace('show', '');
  }, 3000);
}

// LISTENER au chargement de la page
document.addEventListener('DOMContentLoaded', function () {
  var container = document.querySelector('.card-results-container');
  if (container) {
    addEventListenersToElements(container);
  }
});

// MUTATIONOBSERVER pour surveiller les changements dans le container "card-results-container"
// (pour ensuite pouvoir mettre des listeners sur chaque bouton "+ AJOUTER" à chaque fois que le contenu du contenu change)
var observer = new MutationObserver(function (mutations) {
  mutations.forEach(function (mutation) {
    if (mutation.type === 'childList') {
      // Vérifiez si de nouveaux éléments ont été ajoutés
      if (mutation.addedNodes.length) {
        var container = document.querySelector('.card-results-container');
        closeModalButton.removeEventListener('click', onButtonCloseClick);
        window.removeEventListener('click', onWindowsClick);
        listRadio.removeEventListener('change', onListRadioChange);
        cellierRadio.removeEventListener('change', onCellierRadioChange);
        form.removeEventListener('submit', onFormSubmit);
        addEventListenersToElements(container);
      }
    }
  });
});
var config = {
  childList: true,
  subtree: true
};
var targetNode = document.querySelector('.card-results-container');
if (targetNode) {
  observer.observe(targetNode, config);
}

// FONCTION pour ajouter des listeners (pour bouton +Ajouter et boutons de la fenêtre modale)
function addEventListenersToElements(container) {
  // Ajouter un événement d'écouteur de clic à chaque bouton "+ Ajouter"
  var ajouterButtons = document.querySelectorAll('.btn-ajouter');
  ajouterButtons.forEach(function (button) {
    button.removeEventListener('click', onButtonClick);
    button.addEventListener('click', onButtonClick);
  });

  // Ajouter un événement d'écouteur de clic au bouton "annuler"
  closeModalButton.addEventListener('click', onButtonCloseClick);

  // Fermer la fenêtre modale lorsque l'utilisateur clique en dehors de celle-ci
  window.addEventListener('click', onWindowsClick);

  // Listeners pour le radio (choix entre cellier ou liste)
  listRadio.addEventListener('change', onListRadioChange);
  cellierRadio.addEventListener('change', onCellierRadioChange);

  // Listener pour le formulaire d'ajout de bouteille
  form.addEventListener('submit', onFormSubmit);
}
/******/ })()
;