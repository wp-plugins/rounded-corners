<?php
	$rounded = get_option('rounded');
?>
<script type="text/javascript" src="/<?php echo PLUGINDIR; ?>/rounded/mt-core.js"></script>
<script type="text/javascript" src="/<?php echo PLUGINDIR; ?>/rounded/mt-more.js"></script>
<script type="text/javascript" src="/<?php echo PLUGINDIR; ?>/rounded/rounded.js"></script>
<script type="text/javascript">
	var elements = [];
	function _$ (id) { return document.getElementById(id); }
	function add_element () {
		error = false;
		if (_$('new_element_id').value.length == 0) {
			error = true;
			fx = new Fx.Morph('new_element_id', {duration: 'short', transition: Fx.Transitions.Sine.easeOut});
			fx.start({
				'background-color': '#FFF4F4',
				'border-color': '#FF0000',
				'border-width': 3
			});
		} else {
			fx = new Fx.Morph('new_element_id', {duration: 'short', transition: Fx.Transitions.Sine.easeOut});
			fx.start({
				'background-color': '#FFFFFF',
				'border-color': '#C6D9E9',
				'border-width': 1
			});
		}
		if (_$('new_radius').value.length == 0) {
			error = true;
			fx = new Fx.Morph('new_radius', {duration: 'short', transition: Fx.Transitions.Sine.easeOut});
			fx.start({
				'background-color': '#FFF4F4',
				'border-color': '#FF0000',
				'border-width': 3
			});
		} else {
			fx = new Fx.Morph('new_radius', {duration: 'short', transition: Fx.Transitions.Sine.easeOut});
			fx.start({
				'background-color': '#FFFFFF',
				'border-color': '#C6D9E9',
				'border-width': 1
			});
		}
		if (_$('new_color').value.length == 0) {
			error = true;
			fx = new Fx.Morph('new_color', {duration: 'short', transition: Fx.Transitions.Sine.easeOut});
			fx.start({
				'background-color': '#FFF4F4',
				'border-color': '#FF0000',
				'border-width': 3
			});
		} else {
			fx = new Fx.Morph('new_color', {duration: 'short', transition: Fx.Transitions.Sine.easeOut});
			fx.start({
				'background-color': '#FFFFFF',
				'border-color': '#C6D9E9',
				'border-width': 1
			});
		}
		if (error) {
			setTimeout('hide_errors()', 5000);
			box = new Element('div', {
				'id': 'error_box',
				'html': "We've detected errors with your element. Correct the highlighted boxes.",
				'styles': {
					'font-size': 0,
					'background-color': '#FFFFFF',
					'margin': '6px 0px',
					'padding': '8px',
					'display': 'block',
					'border': '1px solid #C6D9E9'
				}
			});
			$('new_element_errors').appendChild(box);
			fx = new Fx.Morph('error_box', {duration: 'long', transition: Fx.Transitions.Sine.easeOut});
			fx.start({
				'font-size': 14,
				'background-color': '#FFF4F4',
				'border-width': 3,
				'border-color': '#FF0000'
			});
			hide_errors = function () {
				setTimeout("$('error_box').parentNode.removeChild($('error_box'));", 1000);
				fx2 = new Fx.Morph('error_box', {duration: 1000, transition: Fx.Transitions.Sine.easeOut});
				fx2.start({
					'font-size': 0,
					'opacity': 0,
					'moz-opacity': 0,
					'khtml-opacity': 0,
					'border-width': 0,
					'border-color': '#FFFFFF'
				});
			}
		} else {
			elements.push({
				'element_id': _$('new_element_id').value,
				'radius': _$('new_radius').value,
				'color': _$('new_color').value.replace('#', '')
			});
			extra = elements.length == 1 ? ', $(\'new_elements_container\')' : '';
			$('new_elements_container').set({'styles': {'display': 'block'}});
			element = new Element('tr', {'valign': 'top', 'id': 'new-element-' + $('new_element_id').value});
			$('new_elements_list').appendChild(element);
			element_id = new Element('td', {'html': '<?php _e('<strong>Element ID</strong><br />'); ?>' + _$('new_element_id').value + '<input type="hidden" name="element_id[]" value="' + _$('new_element_id').value + '" />'});
			element.appendChild(element_id);
			radius = new Element('td', {'html': '<?php _e('<strong>Corner Radius</strong><br />'); ?>' + _$('new_radius').value + ' pixels<input type="hidden" name="radius[]" value="' + _$('new_radius').value + '" />'});
			element.appendChild(radius);
			color = new Element('td', {'html': '<?php _e('<strong>Surrounding Color</strong><br />'); ?>#' + _$('new_color').value + '<input type="hidden" name="color[]" value="' + _$('new_color').value.replace('#', '') + '" />'});
			element.appendChild(color);
			button = new Element('td', {'html': '<input type="button" class="button" value="Remove" onclick="remove(\'new-element-' + _$('new_element_id').value + '\'' + extra + ');" />'});
			element.appendChild(button);
			$('new_element_id').value = $('new_radius').value = $('new_color').value = '';
		}
	}
	function remove (id, parent) {
		parent = $(id).parentNode;
		setTimeout("$('" + id + "').parentNode.removeChild($('" + id + "'));", 1000);
		fx = new Fx.Morph(id, {duration: 1000, transition: Fx.Transitions.Sine.easeOut});
		fx.start({
			'opacity': 0,
			'height': 0
		});
		if (parent.childNodes.length == 1) {
			setTimeout("parent.style.display = 'none';", 1000);
			fx2 = new Fx.Morph(parent, {duration: 1000, transition: Fx.Transitions.Sine.easeOut});
			fx2.start({
				'opacity': 0,
				'height': 0
			});
		}
	}
	window.onload = function () {
		accordion = new Accordion($$('.accordion-link'), $$('.accordion-expander'), {show: -1, opacity: true, alwaysHide: true, height: true});
		$$('#elements_container input[type=text]').each(function(input){input.onkeyup = function (e) {
			if (input.value.length < 1) {
				fx = new Fx.Morph(input, {duration: 'short', transition: Fx.Transitions.Sine.easeOut});
				fx.start({
					'background-color': '#FFF4F4',
					'border-color': '#FF0000',
					'border-width': 3
				});
			} else {
				fx = new Fx.Morph(input, {duration: 'short', transition: Fx.Transitions.Sine.easeOut});
				fx.start({
					'background-color': '#FFFFFF',
					'border-color': '#C6D9E9',
					'border-width': 1
				});
			}
		}});
	}
</script>
<style type="text/css">
	em.pre {
		font-family: "Courier New", Courier, monospace;
		font-weight: bold;
		font-style: normal;
	}
	p {
		width: 100%;
	}
</style>
<div class="wrap">
	<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
		<input type="hidden" name="action" value="save_rounded" />
		<h2>Rounded Corners</h2>
		<h3><?php _e('Add a New Element'); ?></h3>
		<div id="new_element_errors"></div>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<td>
						<strong><?php _e('Element ID (<a href="#" class="accordion-link">help</a>)'); ?></strong><br />
						<input type="text" name="new_element_id" id="new_element_id" />
					</td>
					<td>
						<strong><?php _e('Corner Radius'); ?></strong><br />
						<input type="text" name="new_radius" id="new_radius" value="6" />px
					</td>
					<td>
						<strong><?php _e('Surrounding Color (<a href="#" class="accordion-link">help</a>)'); ?></strong><br />
						#<input type="text" name="new_color" id="new_color" value="FFFFFF" />
					</td>
					<td valign="middle"><input type="button" class="button" value="Add Element" onclick="add_element();" /></td>
				</tr>
			</tbody>
		</table>
		<div class="accordion-expander">
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">
							Wildcards
						</th>
						<td width="">
							<p>
								If you would like to match more than one element, you may use wildcards. Simply add a <em class="pre">*</em> identifier to an element's ID where you would like variation to be accepted.
							</p>
							<p>
								For example, if you want to find all elements with a post number in the ID, you would type <em class="pre">post-*</em>. This will apply corners to all elements which have an ID beginning in <em class="pre">post-</em>.
							</p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="accordion-expander">
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">
							Surrounding Color
						</th>
						<td width="">
							<p>
								Not sure what to put in the Surrounding Color box? Not to worry - just type in the color <em>behind</em> the element which the corners will be applied to. 
							</p>
							<p>
								For example, if you have a menu bar on top of a body with a black background, you would type in <em class="pre">#000000</em>.
							</p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div id="new_elements_container" style="display: none;">
			<h3><?php _e('New Elements'); ?></h3>
			<table class="form-table">
				<tbody id="new_elements_list"></tbody>
			</table>
		</div>
<?php
		if (count($rounded) > 0):
?>
		<div id="elements_container">
			<h3><?php _e('Existing Elements');?></h3>
			<table class="form-table">
				<tbody>
<?php
			foreach ($rounded as $element):
				$extra = count($rounded) == 1 ? ', _$(\'elements_container\')' : '';
?>
					<tr valign="top" id="element-<?php echo $element[0]; ?>">
						<td>
							<?php _e('<strong>Element ID</strong><br />'); ?>
							<input type="text" name="element_id[]" value="<?php _e($element[0]); ?>" />
						</td>
						<td>
							<?php _e('<strong>Corner Radius</strong><br />'); ?>
							<input type="text" name="radius[]" value="<?php _e($element[1]); ?>" /> pixels
						</td>
						<td>
							<?php _e('<strong>Surrounding Color</strong><br />'); ?>
							#<input type="text" name="color[]" value="<?php _e($element[2]); ?>" />
						</td>
						<td valign="middle">
							<input type="button" class="button" value="Remove" onclick="remove('element-<?php echo $element[0]; ?>'<?php echo $extra; ?>);" />
						</td>
					</tr>
<?php
			endforeach;
?>
				</tbody>
			</table>
		</div>
<?php
		endif;
?>
		<br /><input type="submit" class="button" value="Save Rounded Corners Options" />
	</form>
</div>