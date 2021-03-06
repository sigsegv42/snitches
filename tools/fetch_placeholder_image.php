<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 */

// bootstrap the library
require realpath(__DIR__ . '/../backend/vendor/') . '/autoload.php';

use BT\Core\Cli;

use Snitches\Image\Placeholder;

/**
 * CLI tool for fetching placeholder images
 */
class ImageFetcher extends Cli {
	/**
	 * Run the tool
	 *
	 * @param array $argv raw command line arguments
	 */
	public function run($argv) {
		if (sizeof($argv) < 4) {
			echo "Usage: " . $argv[0] . ' <width> <height> <filename> [label] [background_color] [text_color]' . "\n";
			return;
		}
		$width = $argv[1];
		$height = $argv[2];
		$filename = $argv[3];
		$label = null;
		$background = null;
		$foreground = null;
		if (sizeof($argv) >= 5) {
			$label = $argv[4];
		}
		if (sizeof($argv) >= 6) {
			$background = $argv[5];
		}
		if (sizeof($argv) >= 7) {
			$foreground = $argv[6];
		}
		$outdir = realpath(__DIR__ . '/cache/');
		$placeholder = new Placeholder($this->_log, $outdir);
		$ret = $placeholder->fetch($width, $height, $filename, $label, $background, $foreground);
		if ($ret === false) {
			echo 'Error fetching placeholder image!' . "\n";
			return;
		}
	}
}


$fetcher = new ImageFetcher(realpath(__DIR__ . '/../backend/app/'));
$fetcher->run($argv);
