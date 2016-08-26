<?php
/**
 * Part of CI PHPUnit Test
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2015 Kenji Suzuki
 * @link       https://github.com/kenjis/ci-phpunit-test
 */

namespace Kenjis\MonkeyPatch\Patcher;

use PhpParser\Parser;
use PhpParser\Lexer;
use PhpParser\NodeTraverser;

abstract class AbstractPatcher
{
	protected $node_visitor;

	public static $replacement;

	public function patch($source)
	{
		$patched = false;
		static::$replacement = [];

		$parser = new Parser(new Lexer(
			['usedAttributes' => ['startTokenPos', 'endTokenPos']]
		));
		$traverser = new NodeTraverser;
		$traverser->addVisitor($this->node_visitor);

		$ast_orig = $parser->parse($source);
		$traverser->traverse($ast_orig);

		if (static::$replacement !== [])
		{
			$patched = true;
			$new_source = static::generateNewSource($source);
		}
		else
		{
			$new_source = $source;
		}

		return [
			$new_source,
			$patched,
		];
	}
}
