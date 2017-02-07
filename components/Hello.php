<?php

namespace app\components;

use yii\helpers\Html;
use yii\base\Widget;

class Hello extends Widget
{

	public $message;

	public function run()
	{
		$b = HTML::tag("b", $this->message);
		$p = Html::tag("p", $b);

		return $p;
	}

}

//  <p><b>message</b></p>

?>

