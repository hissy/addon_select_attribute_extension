<?php	defined('C5_EXECUTE') or die("Access Denied.");?>

<?php	if ($this->controller->getTask() == 'select') { ?>

<?php	echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Select Attribute Extension'), false, 'span10 offset1', false)?>

<form method="post" action="<?php	echo $this->action('add')?>" method="post" class="form-horizontal">

<div class="ccm-pane-body">
	<fieldset>
		<legend><?php	echo t('Select attribute value to set extension data'); ?></legend>
		<div class="control-group">
			<?php	echo $form->label('akID', t('Attribute Key')); ?>
			<div class="controls">
				<?php	echo $form->select('akID',$akOptions); ?>
			</div>
		</div>
		<div class="control-group">
			<?php	echo $form->label('ID', t('Attribute Option')); ?>
			<div id="ak-select-option" class="controls"></div>
		</div>
	</fieldset>
</div>
<div class="ccm-pane-footer">
	<a href="<?php	echo View::url('/dashboard/pages/select_attribute_extension')?>" class="btn"><?php	echo t("Cancel")?></a>
	<input type="submit" name="submit" value="<?php	echo t('Add extension data')?>" class="ccm-button-right primary btn" />
</div>
</form>

<?php
$uh = Loader::helper('concrete/urls');
$toolURL = $uh->getToolsURL('dashboard/search_attribute_keys','select_attribute_extension');
?>
<script type="text/javascript">
$(function(){
	$('#akID').change(function(){
		$.ajax({
			url: "<?php	echo $toolURL; ?>",
			type: "post",
			data: { 'akID': $(this).val() }
		}).done(function(r){
			$('#ak-select-option').html(r);
		});
	});
});
</script>

<?php	echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false)?>

<?php	} elseif ($this->controller->getTask() == 'add' || $this->controller->getTask() == 'add_select_extension') { ?>

<?php	echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Select Attribute Extension'), false, 'span10 offset1', false)?>

<form method="post"  action="<?php	echo $this->action('add_select_extension')?>" method="post" class="form-horizontal">
<?php	echo Loader::helper('validation/token')->output('add_select_extension')?>

<div class="ccm-pane-body">
	<fieldset>
		<?php
		echo $form->hidden('ID',$atSelectOption->getSelectAttributeOptionID());
		$atSelectOptionValue = $atSelectOption->getSelectAttributeOptionValue();
		
		if (is_object($ak)) {
			echo $form->hidden('akID',$ak->getAttributeKeyID());
			$akName = tc('AttributeKeyName', $ak->getAttributeKeyName());
			echo '<legend>'.t('Set extension data for %1$s of %2$s',$atSelectOptionValue,$akName).'</legend>';
		} else {
			echo '<legend>'.t('Set extension data for %s',$atSelectOptionValue).'</legend>';
		}
		
		?>
		<div class="control-group">
			<?php	echo $form->label('thumbnail', t('Thumbnail')); ?>
			<div class="controls">
				<?php	$al = Loader::helper('concrete/asset_library'); ?>
				<?php	echo $al->image('thumbnail', 'thumbnail', 'Select Thumbnail Image', $thumbnail); ?>
			</div>
		</div>
		<div class="control-group">
			<?php	echo $form->label('description', t('Description')); ?>
			<div class="controls">
				<?php	echo $form->textarea('description',$description,array('class'=>'input-xxlarge','rows'=>3)); ?>
			</div>
		</div>
		<div class="control-group">
			<?php	echo $form->label('class', t('CSS Class')); ?>
			<div class="controls">
				<?php	echo $form->text('class',$class,array('class'=>'input-xlarge')); ?>
			</div>
		</div>
	</fieldset>
</div>
<div class="ccm-pane-footer">
	<a href="<?php	echo View::url('/dashboard/pages/select_attribute_extension')?>" class="btn"><?php	echo t("Cancel")?></a>
	<input type="submit" name="submit" value="<?php	echo t('Save')?>" class="ccm-button-right primary btn" />
</div>
</form>

<?php	echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false)?>

<?php	} else { ?>

<?php	echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Select Attribute Extension'), false, 'span10 offset1', false)?>

<div class="ccm-pane-body">

<a href="<?php	echo View::url('/dashboard/pages/select_attribute_extension', 'select')?>" style="float: right; margin-bottom: 10px" class="btn primary"><?php	echo t("Add Extension Data")?></a>

<div id="ccm-list-wrapper">
<?php
if (is_array($dataArray) && count($dataArray) > 0) {
	?>
	<table border="0" cellspacing="0" cellpadding="0" class="ccm-results-list">
		<thead>
			<tr>
				<th><?php	echo t('Option Name'); ?></th>
				<th><?php	echo t('Thumbnail'); ?></th>
				<th><?php	echo t('Description'); ?></th>
				<th><?php	echo t('CSS class'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ($dataArray as $data) {
			
			if (!isset($striped) || $striped == 'ccm-list-record-alt') {
				$striped = '';
			} else if ($striped == '') { 
				$striped = 'ccm-list-record-alt';
			}
			
			$opt = SelectAttributeTypeOption::getByID($data->ID);
			if (is_object($opt)) {
			?>
			<tr class="ccm-list-record <?php	echo $striped?>">
				<td><?php
				echo sprintf('<a href="%s?ID=%s">%s</a>',
					View::url('/dashboard/pages/select_attribute_extension', 'add'),
					$data->getID(),
					$opt->getSelectAttributeOptionValue()
				);
				?></td>
				<td><?php
				$f = File::getByID($data->getThumbnailID());
				if (!$f->isError()){
					$fv = $f->getApprovedVersion();
					?><span style="float:left;" class="thumbnail"><?php
					echo $fv->getThumbnail(1);
					?></span><?php
				}
				?></td>
				<td><?php echo $data->getDescription(); ?></td>
				<td><?php echo $data->getCssClass(); ?></td>
			</tr>
			<?php
			}
		}
		?>
		</tbody>
	</table>
	<?php
} else {
	?>
	<div id="ccm-list-none"><?php	echo t('No data found.')?></div>
	<?php
}
?>
</div>

</div>
<div class="ccm-pane-footer">

<h1><?php	echo t('Example'); ?></h1>
<pre>
&lt;?php
// Load Model
Loader::model('select_option_extension','select_attribute_extension');

// Get current page
$c = Page::getCurrentPage();

// Get tags attribute of current page
$tags = $c->getAttribute('tags');

// Get option list
$options = $tags->getOptions();

foreach ($options as $opt) {
	// Get option value
	$optValue = $opt->getSelectAttributeOptionValue();
	// Get option ID
	$optID = $opt->getSelectAttributeOptionID();
	// Get extension data
	$ext = SelectOptionExtention::getByID($optID);
	
	$img = '';
	$description = '';
	$class = '';
	if (is_object($ext)) {
		$f = File::getByID($ext->getThumbnailID());
		$fullPath = $f->getPath();
		$size = @getimagesize($fullPath);
		if (!empty($size)){
			$ih = Loader::helper('image');
			$thumb = $ih->getThumbnail($f, 80, 80);
			$img = sprintf(
				'&lt;img src="%s" width="%d" height="%d" alt="%s" /&gt;',
				$thumb->src,
				$thumb->width,
				$thumb->height,
				$optValue
			);
		}
		$description = $ext->getDescription();
		$class = $ext->getCssClass();
	}
	?&gt;
	&lt;div class="tag &lt;?php echo $class; ?&gt;"&gt;
		&lt;div class="name"&gt;&lt;?php echo $optValue; ?&gt;&lt;/div&gt;
		&lt;div class="thumbnail"&gt;&lt;?php echo $img; ?&gt;&lt;/div&gt;
		&lt;div class="description"&gt;&lt;?php echo $description; ?&gt;&lt;/div&gt;
	&lt;/div&gt;
	&lt;?php
}
?&gt;
</pre>

</div>

<?php	echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false)?>

<?php	}