<?php 
echo $this->Html->script('jquery'); // Include jQuery library
echo $this->Html->script('jquery-ui'); // Include jQuery UI library
echo $this->Html->css('ui-lightness/jquery-ui');


echo $this->Form->create();
?>

<style media="screen, print" type="text/css">
.fg-button { 
   outline: 0; 
   margin:0; 
   padding: .4em 1em; 
   text-decoration:none !important; 
   cursor:pointer; 
   position: relative; 
   text-align: center; 
   zoom: 1; 
   float: left;
   }
</style>

<script type="text/javascript">
$(document).ready(function() {
    $(".Options").buttonset();

});

</script>

<div class="Options list">
	<?php
	$this->Js->get('[for=\'ShiftShiftsToShowAll\']')->event('click', '$(\'#pick-doctor\').hide()', array ('stop' => false));
	$this->Js->get('[for=\'ShiftShiftsToShowMine\']')->event('click', '$(\'#pick-doctor\').hide()', array ('stop' => false));
	$this->Js->get('[for=\'ShiftShiftsToShowSome\']')->event('click', '$(\'#pick-doctor\').show()', array ('stop' => false));
	
	echo $this->Form->radio('Shifts to show', array ('mine' => 'My shifts only', 'all' => 'Everybody\'s shifts', 'some' => 'Let me pick'),
			array (
					'name' => 'data[Shift][list]')
			);
	?>
</div>

<div id="pick-doctor" style="display:none">
	<?= $this->PhysicianPicker->makePhysicianPicker($physicians, 'data[Shift]'); ?>
</div>

<fieldset>
	<legend>Calendar to show</legend>
	<?php 
		echo $this->Form->input('calendar', array(
				'required' => true,
				'label' => false,
				'options' => $calendars));
	?>
</fieldset>

	<?= $this->Form->checkbox('archive');?>Include archived calendars
	<?= $this->Js->get('#ShiftArchive')->event('click', 'shiftArchive()', array ('stop' => false));?>

<div class="Options">
<?php echo $this->Form->radio('Output Format', array ('webcal' => 'Web calendar', 'list' => 'List of shifts', 'print' => 'Print copy', 'ics' => 'ICS'),
		array (
				'name' => 'data[Shift][output]')
		);
?>
</div>
<?= $this->Form->submit();?>

<script>
	function shiftArchive(data) {
		if ($('input[name="data[Shift][archive]"]').is(':checked') == true) { 
			var endDate = 'archive';
		} else {
			var endDate = 'current';
		}
		$.getJSON('<?= $this->Html->url(array('controller' => 'shifts', 'action' => 'listCalendars.json')); ?>', {end_date: endDate}, function(data){
				$("select#ShiftCalendar").empty();
				var html = '';
				var len = data.calendars.length;
				for (var i = 0; i< len; i++) {
					html += '<option value="' + data.calendars[i].Calendar.id + '">' + data.calendars[i].Calendar.name + '</option>';
				}
				$('select#ShiftCalendar').append(html);
			});
	}
</script>	

	
<?= $this->Js->writeBuffer(); // Write cached scripts ?>
