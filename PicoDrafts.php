<?php
/**
 * Pico Drafts
 *
 * @author Andrew Meyer
 * @link http://rewdy.com
 * @license http://opensource.org/licenses/MIT
 * @version 1.4
 */
class PicoDrafts extends AbstractPicoPlugin
{
	const API_VERSION = 2;

	protected $enabled = false;

	protected $path = '';
	protected $preview = false;

	public function onPagesLoaded(&$pages)
	{
		if (! $this->preview) {
			$pages = array_filter($pages, function ($page) {
				return ! $page['hidden'];
			});
		}
	}

	public function onRequestFile(&$path)
	{
		$this->path = $path;
	}

	public function on404ContentLoaded(&$rawContent)
	{
		if ($this->preview) {
			$pico = $this->getPico();

			// Reset content and header
			$rawContent = $pico->loadFileContent($this->path);
			header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
		}
	}

	public function onRequestUrl(&$url)
	{
		$this->preview = (strpos($url, '/preview') !== false) ? true : false;

		if ($this->preview) {
			$url = str_replace('/preview', '', $url);
		}
	}
}
