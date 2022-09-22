<?php namespace Widgets;

/*
 *
 * LISTVIEW VIEW WIDGET CLASS
 * By: C. Moller - 29 Apr 2016
 *
 */

class ListView
{

	/*
	 *
	 *
	 */
	public function render($list, $class = 'list-view', $remove = null, $style = 'table', $layout = 'horizontal')
	{
		$html = '';

		$remove = $remove?:[];

		if (is_array($list) and !empty($list) and (is_object($list[0]) or is_array($list[0])))
		{
			$indent = 1;
			$html .= indent($indent) . '<table class="' . $class . '">' . PHP_EOL;

			$indent++;
			$html .= indent($indent) . '<thead><tr>' . PHP_EOL;

			$indent++;
			foreach ($list[0] as $key => $value)
			{
				if (in_array($key, $remove)) continue;
				$html .= indent($indent) . '<th class="'.$key.'_col">' . $key . '</th>' . PHP_EOL;
			}

			$indent--;
			$html .= indent($indent+1) . '</tr></thead>' . PHP_EOL;
			$html .= indent($indent+1) . '<tbody class="striped">' . PHP_EOL;

			$indent++;
			foreach ($list as $tr)
			{
				$html .= indent($indent) . '<tr>' . PHP_EOL;

				$indent++;
				$html .= indent($indent);
				foreach ($tr as $key => $value)
				{
					if (in_array($key, $remove)) continue;
					$html .= '<td class="nowrap '.$key.'_col" title="' . $value . '">' . $value . '</td>';
				}

				$indent--;
				$html .= PHP_EOL . indent($indent) . '</tr>' . PHP_EOL;
			}

			$indent--;
			$html .= indent($indent+1) . '</tbody>' . PHP_EOL;

			$indent--;
			$html .= indent($indent) . '</table>' . PHP_EOL;
		}

		return trim($html) . PHP_EOL;
	}


	public function __toString()
	{
		return ' * ListView Widget * ';
	}

}
