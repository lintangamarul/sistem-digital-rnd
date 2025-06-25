<?php $isEdit = true; ?>
<form action="<?= site_url('die-cons/'.$item['id']) ?>" method="post" enctype="multipart/form-data" style="max-width:600px; margin:auto;">
  <?= csrf_field() ?>
  <input type="hidden" name="_method" value="PUT">

  <h2 style="text-align:center; margin-bottom:30px;">Edit Die Construction Image #<?= $item['id'] ?></h2>

  <!-- PROSES -->
  <div style="margin-bottom:20px;">
    <label style="font-weight:bold;">Proses:</label><br>
    <?php 
      $opts = ["DRAW","FORM","BEND","REST","FLANGE","BLANK","TRIM","SEP","PIE"];
      $sel = explode(',', $item['proses']);
    ?>
    <div style="margin-top:8px;">
      <?php foreach($opts as $o): ?>
        <label style="margin-right:15px;">
          <input 
            type="checkbox" 
            name="proses[]" 
            value="<?= $o ?>"
            <?= in_array($o, $sel) ? 'checked' : '' ?>
          > <?= $o ?>
        </label>
      <?php endforeach ?>
    </div>
  </div>

  <!-- PAD LIFTER -->
  <div style="margin-bottom:20px;">
    <label style="font-weight:bold;">Pad Lifter:</label><br>
    <select name="pad_lifter" required style="margin-top:8px; padding:6px 10px; width:100%;">
      <option value="">-- Pilih Pad Lifter --</option>
      <?php foreach (["Gas-Spring","Coil-Spring","Gas-Tank"] as $pl): ?>
        <option value="<?= $pl ?>" <?= $item['pad_lifter'] === $pl ? 'selected' : '' ?>>
          <?= $pl ?>
        </option>
      <?php endforeach ?>
    </select>
  </div>

  <!-- CASTING PLATE -->
  <div style="margin-bottom:20px;">
    <label style="font-weight:bold;">Casting Plate:</label><br>
    <?php 
      $plates = ["PlateA","PlateB","PlateC"];
      $selPlate = explode(',', $item['casting_plate']);
    ?>
    <div style="margin-top:8px;">
      <?php foreach($plates as $p): ?>
        <label style="margin-right:15px;">
          <input 
            type="checkbox" 
            name="casting_plate[]" 
            value="<?= $p ?>"
            <?= in_array($p, $selPlate) ? 'checked' : '' ?>
          > <?= $p ?>
        </label>
      <?php endforeach ?>
    </div>
  </div>

  <!-- IMAGE UPLOAD -->
  <div style="margin-bottom:30px;">
    <label style="font-weight:bold;">Image (kosongkan jika tidak ingin mengganti):</label><br>
    <?php if($item['image']): ?>
      <div style="margin-top:10px;">
        <img src="<?= base_url('uploads/die_cons/'.$item['image']) ?>" width="150" style="border:1px solid #ccc; padding:4px; background:#fafafa;">
      </div>
    <?php endif ?>
    <input type="file" name="image" accept="image/*" style="margin-top:10px;">
  </div>

  <!-- BUTTON -->
  <div style="text-align:center;">
    <button type="submit" style="background-color:#4CAF50; color:white; padding:10px 20px; border:none; border-radius:5px; cursor:pointer;">
      Update
    </button>
  </div>
</form>
