<?php

namespace mageekguy\atoum\annotations;

class extractor implements \iteratorAggregate
{
	protected $annotations = array();

	public function __construct($comments = null)
	{
		if ($comments !== null)
		{
			$this->extract($comments);
		}
	}

	public function extract($comments)
	{
		$comments = trim((string) $comments);

		if (substr($comments, 0, 3) == '/**' && substr($comments, -2) == '*/')
		{
			foreach (explode("\n", trim(trim($comments, '/*'))) as $comment)
			{
				$comment = preg_split("/\s+/", trim(trim(trim($comment), '*/')));

				if (sizeof($comment) == 2)
				{
					if (substr($comment[0], 0, 1) == '@')
					{
						$this->annotations[substr($comment[0], 1)] = $comment[1];
					}
				}
			}
		}

		return $this;
	}

	public function getIterator()
	{
		return new \arrayIterator($this->annotations);
	}

	public function getAnnotations()
	{
		return $this->annotations;
	}
}

?>
