<?php
/* @var $this AnginController */
/* @var $data Angin */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_angin')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_angin), array('view', 'id'=>$data->id_angin)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_station')); ?>:</b>
	<?php echo CHtml::encode($data->id_station); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nilai')); ?>:</b>
	<?php echo CHtml::encode($data->nilai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('waktu')); ?>:</b>
	<?php echo CHtml::encode($data->waktu); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ket')); ?>:</b>
	<?php echo CHtml::encode($data->ket); ?>
	<br />


</div>