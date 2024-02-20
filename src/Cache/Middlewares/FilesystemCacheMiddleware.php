<?php

namespace Secco2112\SteamAPI\Cache\Middlewares;

use Secco2112\SteamAPI\Cache\AbstractCacheMiddleware;
use Secco2112\SteamAPI\Cache\ICacheMiddleware;

class FilesystemCacheMiddleware extends AbstractCacheMiddleware implements ICacheMiddleware {

	/** @var string */
	private $basePath = '';


	public function __construct() {
		$this->basePath = dirname(__FILE__) . '../../../../.cache';
	}

	public function setBasePath(string $basePath): self {
		$this->basePath = $basePath;

		return $this;
	}

	public function setup(): void {
		$this->createBasePath();
	}

	protected function validate(): bool {
		return true;
	}

	public function getData(string $key) {
		$cachedFiles = $this->getCachedFiles();
		
		if (empty($cachedFiles)) {
			return false;
		}

		if (!in_array($key, $cachedFiles)) {
			return false;
		}

		$filePath = $this->basePath . '/' . $key;
		$cachedContent = file_get_contents($filePath);

		if ($this->fileExpired($cachedContent)) {
			$this->deleteFile($filePath);
			return false;
		}

		return $cachedContent;
	}

	public function store(string $key, $data, int $expirationTime): void {
		$data = json_decode(unserialize($data));
		$data->expirationTime = time() + $expirationTime;

		$data = serialize(json_encode($data));

		$filePath = $this->basePath . '/' . $key;

		@file_put_contents($filePath, $data);
	}

	private function createBasePath(): void {
		if (is_dir($this->basePath)) {
			return;
		}

		mkdir($this->basePath, 0777, true);
	}

	private function getCachedFiles() {
		return array_values(array_filter(scandir($this->basePath), function($file) {
			return !in_array($file, ['.', '..']);
		}));
	}

	private function fileExpired(string $cachedContent): bool {
		$expirationTime = @json_decode(unserialize($cachedContent))->expirationTime ?? false;
		
		if ($expirationTime === false) {
			return true;
		}
		
		return $expirationTime < time();
	}

	private function deleteFile(string $filePath): void {
		unlink($filePath);
	}

}