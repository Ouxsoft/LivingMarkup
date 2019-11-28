<?php

namespace Pxp\DynamicElement\Widgets;

class News extends \Pxp\DynamicElement\DynamicElement
{
	public function onRender(){
		//$out = 'y='.$_POST['focal_point_y'].'x='.$_POST['focal_point_x'] .
		$out =
		'<p>News story</p>
		
		<form method="post">
			<img src="/assets/images/pxp/logo/original.jpg" style="width:100px; height:100px"/>
		</form>
		';

		if(isset($this->args['@attributes']['id'])){
			$out .= '<!-- widget #' . $this->args['@attributes']['id'] . '-->' . PHP_EOL;
		}
		/*}

		// heading
		if(isset($this->args['heading'])){
			$out .= '<h' . $this->size . '>' . $this->args['heading'] . '</h' . $this->size . '>';
		}

		$out .= '<ul>';
		foreach($this->myGenerator() as $row){
			$out .= '<li>' . $row . '</li>';
		}
		$out .= '</ul>';
*/
		return $out;
		
	}
}