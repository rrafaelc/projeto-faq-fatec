!(function (a, b) {
  'function' == typeof define && define.amd
    ? define(b)
    : 'object' == typeof exports
      ? (module.exports = b())
      : (a.VMasker = b());
})(this, function () {
  var a = '9',
    b = 'A',
    c = 'S',
    d = [9, 16, 17, 18, 36, 37, 38, 39, 40, 91, 92, 93],
    e = function (a) {
      for (var b = 0, c = d.length; b < c; b++) if (a == d[b]) return !1;
      return !0;
    },
    f = function (a) {
      return (
        (a = a || {}),
        (a = {
          precision: a.hasOwnProperty('precision') ? a.precision : 2,
          separator: a.separator || ',',
          delimiter: a.delimiter || '.',
          unit: (a.unit && a.unit.replace(/[\s]/g, '') + ' ') || '',
          suffixUnit: (a.suffixUnit && ' ' + a.suffixUnit.replace(/[\s]/g, '')) || '',
          zeroCents: a.zeroCents,
          lastOutput: a.lastOutput,
        }),
        (a.moneyPrecision = a.zeroCents ? 0 : a.precision),
        a
      );
    },
    g = function (d, e, f) {
      for (; e < d.length; e++) (d[e] !== a && d[e] !== b && d[e] !== c) || (d[e] = f);
      return d;
    },
    h = function (a) {
      this.elements = a;
    };
  (h.prototype.unbindElementToMask = function () {
    for (var a = 0, b = this.elements.length; a < b; a++)
      (this.elements[a].lastOutput = ''),
        (this.elements[a].onkeyup = !1),
        (this.elements[a].onkeydown = !1),
        this.elements[a].value.length &&
          (this.elements[a].value = this.elements[a].value.replace(/\D/g, ''));
  }),
    (h.prototype.bindElementToMask = function (a) {
      for (
        var b = this,
          c = function (c) {
            c = c || window.event;
            var d = c.target || c.srcElement;
            e(c.keyCode) &&
              setTimeout(function () {
                (b.opts.lastOutput = d.lastOutput),
                  (d.value = i[a](d.value, b.opts)),
                  (d.lastOutput = d.value),
                  d.setSelectionRange &&
                    b.opts.suffixUnit &&
                    d.setSelectionRange(d.value.length, d.value.length - b.opts.suffixUnit.length);
              }, 0);
          },
          d = 0,
          f = this.elements.length;
        d < f;
        d++
      )
        (this.elements[d].lastOutput = ''),
          (this.elements[d].onkeyup = c),
          this.elements[d].value.length &&
            (this.elements[d].value = i[a](this.elements[d].value, this.opts));
    }),
    (h.prototype.maskMoney = function (a) {
      (this.opts = f(a)), this.bindElementToMask('toMoney');
    }),
    (h.prototype.maskNumber = function () {
      (this.opts = {}), this.bindElementToMask('toNumber');
    }),
    (h.prototype.maskAlphaNum = function () {
      (this.opts = {}), this.bindElementToMask('toAlphaNumeric');
    }),
    (h.prototype.maskPattern = function (a) {
      (this.opts = { pattern: a }), this.bindElementToMask('toPattern');
    }),
    (h.prototype.unMask = function () {
      this.unbindElementToMask();
    });
  var i = function (a) {
    if (!a) throw new Error('VanillaMasker: There is no element to bind.');
    var b = 'length' in a ? (a.length ? a : []) : [a];
    return new h(b);
  };
  return (
    (i.toMoney = function (a, b) {
      if (((b = f(b)), b.zeroCents)) {
        b.lastOutput = b.lastOutput || '';
        var c = '(' + b.separator + '[0]{0,' + b.precision + '})',
          d = new RegExp(c, 'g'),
          e = a.toString().replace(/[\D]/g, '').length || 0,
          g = b.lastOutput.toString().replace(/[\D]/g, '').length || 0;
        (a = a.toString().replace(d, '')), e < g && (a = a.slice(0, a.length - 1));
      }
      var h = a.toString().replace(/[\D]/g, ''),
        i = new RegExp('^(0|\\' + b.delimiter + ')'),
        j = new RegExp('(\\' + b.separator + ')$'),
        k = h.substr(0, h.length - b.moneyPrecision),
        l = k.substr(0, k.length % 3),
        m = new Array(b.precision + 1).join('0');
      k = k.substr(k.length % 3, k.length);
      for (var n = 0, o = k.length; n < o; n++) n % 3 === 0 && (l += b.delimiter), (l += k[n]);
      if (((l = l.replace(i, '')), (l = l.length ? l : '0'), !b.zeroCents)) {
        var p = h.length - b.precision,
          q = h.substr(p, b.precision),
          r = q.length,
          s = b.precision > r ? b.precision : r;
        m = (m + q).slice(-s);
      }
      var t = b.unit + l + b.separator + m + b.suffixUnit;
      return t.replace(j, '');
    }),
    (i.toPattern = function (d, e) {
      var f,
        h = 'object' == typeof e ? e.pattern : e,
        i = h.replace(/\W/g, ''),
        j = h.split(''),
        k = d.toString().replace(/\W/g, ''),
        l = k.replace(/\W/g, ''),
        m = 0,
        n = j.length,
        o = 'object' == typeof e ? e.placeholder : void 0;
      for (f = 0; f < n; f++) {
        if (m >= k.length) {
          if (i.length == l.length) return j.join('');
          if (void 0 !== o && i.length > l.length) return g(j, f, o).join('');
          break;
        }
        if (
          (j[f] === a && k[m].match(/[0-9]/)) ||
          (j[f] === b && k[m].match(/[a-zA-Z]/)) ||
          (j[f] === c && k[m].match(/[0-9a-zA-Z]/))
        )
          j[f] = k[m++];
        else if (j[f] === a || j[f] === b || j[f] === c)
          return void 0 !== o ? g(j, f, o).join('') : j.slice(0, f).join('');
      }
      return j.join('').substr(0, f);
    }),
    (i.toNumber = function (a) {
      return a.toString().replace(/(?!^-)[^0-9]/g, '');
    }),
    (i.toAlphaNumeric = function (a) {
      return a.toString().replace(/[^a-z0-9 ]+/i, '');
    }),
    i
  );
});
