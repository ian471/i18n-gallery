<?php
i18n_gallery_register('nivo', 'Nivo Slider', 
  '<strong>Nivo Slider</strong> - The world\'s most awesome jQuery & WordPress Image Slider<br/>'.
  'License: MIT<br/>'.
  '<a target="_blank" href="http://nivo.dev7studios.com/">http://nivo.dev7studios.com/</a>',
  'i18n_gallery_nivo_edit', 'i18n_gallery_nivo_header', 'i18n_gallery_nivo_content');

function i18n_gallery_nivo_edit($gallery) {
?>
  <p>
    <label for="nivo-width"><?php i18n('i18n_gallery/MAX_DIMENSIONS'); ?></label>
    <input type="text" class="text" id="nivo-width" name="nivo-width" value="<?php echo @$gallery['width']; ?>" style="width:5em"/>
    x
    <input type="text" class="text" id="nivo-height" name="nivo-height" value="<?php echo @$gallery['height']; ?>" style="width:5em"/>
    &nbsp;
    <span id="nivo-crop-span">
      <input type="checkbox" id="nivo-crop" name="nivo-crop" value="1" <?php echo @$gallery['crop'] ? 'checked="checked"' : ''; ?> style="vertical-align:middle"/> 
      <?php i18n('i18n_gallery/CROP'); ?>
    </span>
  </p>
  <script type="text/javascript">
    function changeCycleSize() {
        var show = $.trim($('#nivo-width').val()) != '' && $.trim($('#nivo-height').val()) != '';
        if (show) $('#nivo-crop-span').show(); else $('#nivo-crop-span').hide().find('input').attr('checked',false);
    }
    $(function() {
      $('#nivo-width, #nivo-height').change(changeCycleSize);
      changeCycleSize();
    });
  </script>
  <p>
    <label for="nivo-animation">Slide transition speed (ms)</label>
    <input type="text" class="text" id="nivo-animation" name="nivo-animation" value="<?php echo @$gallery['animation']; ?>" style="width:5em"/>
  </p>
  <p>
    <label for="nivo-interval"><?php i18n('i18n_gallery/INTERVAL'); ?></label>
    <input type="text" class="text" id="nivo-interval" name="nivo-interval" value="<?php echo @$gallery['interval']; ?>" style="width:5em"/>
  </p>
  <p>
    <label for="nivo-effect"><?php i18n('i18n_gallery/EFFECT'); ?></label>
    <select class="text" name="nivo-effect"><?php
$effects = array("sliceDown",
			"sliceDownLeft",
			"sliceUp",
			"sliceUpLeft",
			"sliceUpDown",
			"sliceUpDownLeft",
			"fold",
			"fade",
			"random",
			"slideInRight",
			"slideInLeft",
			"boxRandom",
			"boxRain",
			"boxRainReverse",
			"boxRainGrow",
			"boxRainGrowReverse");
foreach($effects as $effect) { ?>
      <option value="<?php echo $effect; ?>" <?php echo @$gallery['effect'] == $effect ? 'selected="selected"' : ''; ?>><?php echo $effect; ?></option>
<?php
} ?>
    </select>
  </p>
<?php
}

function i18n_gallery_nivo_header($gallery) {
  global $SITEURL;
  if (i18n_gallery_check($gallery,'jquery') && i18n_gallery_needs_include('jquery.js')) {
?>
    <script type="text/javascript" src="<?php echo i18n_gallery_site_link(); ?>plugins/i18n_gallery/js/jquery-1.4.3.min.js"></script>
<?php
  }
  if (i18n_gallery_check($gallery,'js') && i18n_gallery_needs_include('nivo.js')) {
?>
    <script type="text/javascript" src="<?php echo i18n_gallery_site_link(); ?>plugins/i18n_gallery/js/jquery.nivo.slider.pack.js"></script>
<?php
  } 
  if (i18n_gallery_check($gallery,'css') && i18n_gallery_needs_include('nivo.css')) {
?>
	<link rel="stylesheet" type="text/css" href="/getsimple/plugins/i18n_gallery/css/nivo-slider.css">
	<link rel="stylesheet" type="text/css" href="/getsimple/plugins/i18n_gallery/css/nivo-slider-themes/default/default.css">
<?php
  }
}

function i18n_gallery_nivo_content($gallery, $pic) {
  $id = i18n_gallery_id($gallery);
  $w = @$gallery['width'] ? $gallery['width'] : (@$gallery['height'] ? (int) $gallery['height']*$gallery['items'][0]['width']/$gallery['items'][0]['height'] : $gallery['items'][0]['width']);
  $h = @$gallery['height'] ? $gallery['height'] : (@$gallery['width'] ? (int) $gallery['width']*$gallery['items'][0]['height']/$gallery['items'][0]['width'] : $gallery['items'][0]['height']);
  // set gallery width/height for i18n_gallery_image_link:
  $gallery['width'] = $w;
  $gallery['height'] = $h;
  if (!isset($pic) || $pic === null) $pic = 0; else if ($pic < 0) $pic = -$pic-1;
?>
  <div id="gallery-nivo-<?php echo $id; ?>" class="gallery gallery-nivo slider-wrapper gallery-<?php echo $id; ?> theme-default">
	<div class="ribbon"></div>
	<div id="slider-<?php echo $id; ?>" class="nivoSlider">
<?php 
  $count = count($gallery['items']);
  for ($i=0; $i<$count; $i++) {
    $item = $gallery['items'][$i]; 
    $descr = @$item['_description'];
	if(@$item['href']) { ?>
<a href="<?php echo $item['href']; ?>"><?php
	}
?>
		<img src="<?php i18n_gallery_image_link($gallery,$item); ?>" alt="" data-thumb="<?php i18n_gallery_thumb_link($gallery,$item); ?>" title="<?php echo $descr ? "#gallery-text-$i" : ''; ?>"/>
<?php
	if(@$item['href']) { ?></a><?php }
  }
?>
	</div>
	<div class="gallery-text-container">
<?php
  for ($i=0; $i<$count; $i++) {
    $item = $gallery['items'][$i]; 
    $descr = @$item['_description'];
    if ($descr && !preg_match('/^(<p>|<p |<div>|<div ).*/', $descr)) $descr = '<p>'.$descr.'</p>';
?>
      <div id="gallery-text-<?php echo $i; ?>">
<?php
	if (@$item['_title']) {
		if(@$item['href']) {
			?><a href="<?php echo $item['href']; ?>"><?php
		}
		echo '<h2>'.htmlspecialchars($item['_title']).'</h2>'; 
		if(@$item['href']) {
			?></a><?php
		}
	}
	echo $descr;
?>
      </div>
<?php
  }
?>
    </div>
  </div>
  <script type="text/javascript">
$(window).load(function() {
$('#slider-<?php echo $id; ?>').nivoSlider({
	effect: '<?php echo @$gallery['effect'] ? $gallery['effect'] : 'slideInRight'; ?>',
	animSpeed: '<?php echo @$gallery['animation'] ? $gallery['animation'] : '300'; ?>',
	pauseTime: '<?php echo @$gallery['interval'] ? $gallery['interval'] : '6000'; ?>',
	//directionNav: false,
	controlNavThumbs: true,
});
});
  </script>
<?php
}
