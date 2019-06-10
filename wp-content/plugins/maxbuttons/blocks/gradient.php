<?php
namespace MaxButtons;
defined('ABSPATH') or die('No direct access permitted');
$blockClass["gradient"] = "gradientBlock";
$blockOrder[40][] = "gradient";

class gradientBlock extends maxBlock
{
	protected $blockname = "gradient";
	protected $fields = array("gradient_stop" => array("default" => "45",
													   "css" => "gradient-stop",
													   "csspseudo" => "normal,hover",
													   ),

						"gradient_start_opacity" => array("default" => "100",
														"css" => "gradient-start-opacity"),
						"gradient_end_opacity" => array("default" => "100",
														"css" => "gradient-end-opacity"),
						"gradient_start_opacity_hover" => array("default" => "100",
														 "css" => "gradient-start-opacity",
														 "csspseudo" => "hover"),
						"gradient_end_opacity_hover" => array("default" => "100",
													    "css" => "gradient-end-opacity",
													    "csspseudo" => "hover"),
						'use_gradient' => array('default' =>  '0',
											    'css' => 'gradient-use-gradient',
											    'csspseudo' => 'normal,hover',
							),

						);


	public function map_fields($map)
	{

		$map["gradient_stop"]["func"] = "updateGradientOpacity";
		$map["gradient_start_opacity"]["func"] = "updateGradientOpacity";
		$map["gradient_end_opacity"]["func"] = "updateGradientOpacity";
		$map["gradient_start_opacity_hover"]["func"] = "updateGradientOpacity";
 		$map["gradient_end_opacity_hover"]["func"] = "updateGradientOpacity";

		return $map;
	}


	public function admin_fields()
	{
			$data = $this->data[$this->blockname];
			$admin = MB()->getClass('admin');

			$start_block = new maxField('block_start');
			$start_block->name = __('gradient-options', 'maxbuttons');
			$start_block->label = __('Background', 'maxbuttons');
			$admin->addField($start_block);


				$g_start = maxBlocks::getColorValue('gradient_start_color');
				$g_end = maxBlocks::getColorValue('gradient_end_color');
				$gh_start = maxBlocks::getColorValue('gradient_start_color_hover');
				$gh_end = maxBlocks::getColorValue('gradient_end_color_hover');

				$use_gradient = maxBlocks::getValue('use_gradient');

				if (! isset($data['use_gradient'] ))
				{
					if ($g_start != $g_end || $gh_start != $gh_end)
						$use_gradient = true;
					else
						$use_gradient = false;

				}


				$condition = array('target' => 'use_gradient', 'values' => 'checked');
				$gradient_conditional = htmlentities(json_encode($condition));

				$color_copy_self = __("Replace color from other field", "maxbuttons");
				$color_copy_move  = __("Copy Color to other field", "maxbuttons");

				$useg = new maxField('switch');
				$useg->label = __('Use Gradients', 'maxbuttons');
				$useg->name = 'use_gradient';
				$useg->id = $useg->name;
				$useg->value = '1';
				$useg->checked = checked($use_gradient, 1, false);
				$admin->addField($useg, 'start', 'end');

				// Spacer
				$fspacer = new maxField('spacer');
				$fspacer->label = '&nbsp;';
				$fspacer->name = 'gradient_head';
				$fspacer->id = $fspacer->name;
				$admin->addField($fspacer, 'start');


				// Spacer
				$fspacer = clone $fspacer;
				$fspacer->label = __('Start','maxbuttons');
				$fspacer->name = 'gradient_start';
				$fspacer->id = $fspacer->name;
				$admin->addField($fspacer, '','');

				// Spacer
				$fspacer = clone $fspacer;
				$fspacer->label = __('End','maxbuttons');
				$fspacer->name = 'gradient_end';
				$fspacer->id = $fspacer->name;
				$fspacer->conditional = $gradient_conditional;
				$admin->addField($fspacer, '','end');


				// Background Color
				$color = new maxField('color');
				$color->id = 'gradient_start_color';
				$color->name = $color->id;
				$color->value = $g_start;
				$color->label = __('Background color','maxbuttons');
				$color->inputclass = 'square';
 				$color->copycolor = true;
 				$color->bindto = 'gradient_end_color';
				$color->left_title = $color_copy_self;
				$color->right_title = $color_copy_move;
 				$color->copypos = 'right';

			  $admin->addField($color, 'start');

				// Background Color (End Gradient)
				$ecolor = new maxField('color');
				$ecolor->id = 'gradient_end_color';
				$ecolor->name = $ecolor->id;
				$ecolor->value = $g_end;
				$ecolor->inputclass = 'square';
				$ecolor->copycolor = true;
				$ecolor->bindto = $color->id;
				$ecolor->copypos = 'left';
				$ecolor->left_title = $color_copy_move;
				$ecolor->right_title = $color_copy_self;
				$ecolor->conditional = $gradient_conditional;

			  $admin->addField($ecolor, '', 'end');

				// Background Color Hover
				$color_hover = new maxField('color');
				$color_hover->id = 'gradient_start_color_hover';
				$color_hover->name = $color_hover->id;
				$color_hover->value = $gh_start;
				$color_hover->label = __('Background hover','maxbuttons');
				$color_hover->inputclass = 'square';
				$color_hover->copycolor = true;
				$color_hover->bindto = 'gradient_end_color_hover';
				$color_hover->left_title = $color_copy_self;
				$color_hover->right_title = $color_copy_move;
				$color_hover->copypos = 'right';

				$admin->addField($color_hover, 'start', '');

				// Background Color Hover
				$ecolor_hover = new maxField('color');
				$ecolor_hover->id = 'gradient_end_color_hover';
				$ecolor_hover->name = $ecolor_hover->id;
				$ecolor_hover->value = $gh_end;
				$ecolor_hover->inputclass = 'square';
			//	$ecolor_hover->label = __('Color Hover End','maxbuttons');
				$ecolor_hover->copycolor = true;
				$ecolor_hover->bindto = $color_hover->id;
				$ecolor_hover->copypos = 'left';
				$ecolor_hover->left_title = $color_copy_move;
				$ecolor_hover->right_title = $color_copy_self;
				$ecolor_hover->conditional = $gradient_conditional;

				$admin->addField($ecolor_hover, '', 'end');


					$startop = new maxField('number');
					$startop->label = __('Normal Opacity','maxbuttons');
					$startop->name = 'gradient_start_opacity';
					$startop->id = $startop->name;
					$startop->value = maxUtils::strip_px( maxBlocks::getValue('gradient_start_opacity') );
					$startop->min = 1;
					$startop->max = 100;
					$startop->inputclass = 'small';

					$admin->addField($startop, 'start');

					$endop = new maxField('number');
					$endop->name = 'gradient_end_opacity';
					$endop->id = $endop->name;
					$endop->value = maxUtils::strip_px( maxBlocks::getValue('gradient_end_opacity') );
					$endop->setDefault(maxBlocks::getDefault('gradient_end_opacity'));
					$endop->min = 1;
					$endop->max = 100;
					$endop->inputclass = 'small';
					$endop->conditional = $gradient_conditional;

					$admin->addField($endop, '', 'end');

					$startop = new maxField('number');
					$startop->label = __('Hover opacity','maxbuttons');
					$startop->name = 'gradient_start_opacity_hover';
					$startop->id = $startop->name;
					$startop->value = maxUtils::strip_px( maxBlocks::getValue('gradient_start_opacity_hover') );
					//$startop->setDefault(maxBlocks::getDefault('gradient_start_opacity_hover'));
					$startop->min = 1;
					$startop->max = 100;
					$startop->inputclass = 'small';
					$admin->addField($startop, 'start');

					$endop = new maxField('number');
			//		$endop->label = __('Hover Opacity','maxbuttons');
					$endop->name = 'gradient_end_opacity_hover';
					$endop->id = $endop->name;
					$endop->value = maxUtils::strip_px( maxBlocks::getValue('gradient_end_opacity_hover') );
					$endop->setDefault(maxBlocks::getDefault('gradient_end_opacity_hover'));
					$endop->min = 1;
					$endop->max = 100;
					$endop->inputclass = 'small';
					$endop->conditional = $gradient_conditional;
					$admin->addField($endop, '', 'end');

					$stop = new maxField('number');
					$stop->label = __('Gradient stop','maxbuttons');
					$stop->name = 'gradient_stop';
					$stop->id = $stop->name;
					$stop->value = maxUtils::strip_px( maxBlocks::getValue('gradient_stop') );
					$stop->setDefault(maxBlocks::getDefault('gradient_stop'));
					$stop->min = 1;
					$stop->max = 99;
					$stop->inputclass = 'small';
					$stop->start_conditional = $gradient_conditional;

					$admin->addField($stop, 'start', 'end');


					$this->sidebar();
					$endblock = new maxField('block_end');
					$admin->addField($endblock);

} // admin_fields


} // class


?>
