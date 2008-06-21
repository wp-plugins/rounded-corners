// original version from mootools.net forums
// heavily modified by Nick Berlette
// www.pancak.es
var roundCorners = new Class({
	options: {
		radius: 4,
		borderColor: null,
		transition: function (base) {
			base = Math.sqrt(1 - Math.pow(base, 2)) - 1;
			return -base;
		}
	},	
	initialize: function (el, sides, options) {
		this.el = $(el);
		this.setOptions(options);
		sides = (sides) ? sides : 'top, bottom';
		sides.split(',').each(function(side) {
			side = side.clean().test(' ') ? side.clean().split(' ') : [side.trim()];
			this.assemble(side[0], side[1]);
		}, this);
	},
	assemble: function(vertical, horizontal) {
		corner = this.options.borderColor;
		s = function (property, skip_parse) {
			style = skip_parse ? this.el.getStyle(property) : (parseInt(this.el.getStyle(property)) || 0);
			return style;
		}.bind(this);
		sides = {
			left: 'right',
			right: 'left'
		}
		styles = {
			display: 'block',
			backgroundColor: this.options.borderColor,
			zIndex: 1,
			position: 'relative',
			zoom: 1
		}
		for (side in sides) {
			styles['margin-' + side] = '-' + (s('padding-' + side) + s('border-' + side + '-width')) + 'px';
		}
		for (side in {top: 1, bottom: 1}) {
			styles['margin-' + side] = vertical == side ? '0' : (s('padding-' + vertical) - this.options.radius) + 'px';
		}
		handler = new Element('b').setStyles(styles).addClass('corner-container');
		this.options.borderColor = this.options.borderColor || (s('border-' + vertical + '-width') > 0 ? s('border-' + vertical + '-color', 1) : this.el.getStyle('background-color'));
		this.el.setStyle('border-' + vertical, '0').setStyle('padding-' + vertical, '0');
		stripes = [];
		borders = {}
		exMargin = 0;
		for (side in sides) {
			borders[side] = s('border-' + side + '-width',1) + ' ' + s('border-' + side + '-style', 1) + ' ' + s('border-' + side + '-color', 1);
		}
		for (i = 1; i < this.options.radius; i++) {
			margin = Math.round(this.options.transition((this.options.radius - i) / this.options.radius) * this.options.radius);
			styles = {
				backgroundColor: i == 1 ? this.options.borderColor : this.el.getStyle('background-color'),
				display: 'block',
				height: '1px',
				overflow: 'hidden',
				zoom: 1
			}
			for (side in sides) {
				check = horizontal == sides[side];
				styles['border-' + side] = check ? borders[side] : (((exMargin || margin)-margin) || 1) + 'px solid ' + this.options.borderColor ;
				styles['margin-' + side] = check ? 0 : margin + 'px';
			}
			exMargin = margin;
			stripes.push(new Element('b').setStyles(styles).addClass('corner'));
		}
		if (vertical == 'top') {
			this.el.insertBefore(handler, this.el.firstChild);
		} else {
			handler.injectInside(this.el);
			stripes = stripes.reverse();
		}
		stripes.each(function(stripe) {stripe.injectInside(handler);});
	}
});
roundCorners.implement(new Options);
function render_corners (id, _radius, color) {
	$try(function() {
		// wildcards
		if (typeof(id) == 'string' && id.contains('*')) {
			id = id.replace(/\*/g, '');
			elements = $$('*');
			for (x in elements) {
				if (typeof (elements[x].id) != 'undefined') {
					if (elements[x].id.contains(id)) {
						new roundCorners($(elements[x]), false, {radius: _radius, borderColor: color});
					}
				}
			}
		} else {
			new roundCorners($(id), false, {radius: _radius, borderColor: color});
		}
	});
}