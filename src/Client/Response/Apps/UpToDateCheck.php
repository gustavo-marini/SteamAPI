<?php

namespace Secco2112\SteamAPI\Client\Response\Apps;

use Secco2112\SteamAPI\Client\Response\AbstractResponse;

class UpToDateCheck extends AbstractResponse {

	public function init(object $response): void {
		$dataResponse = $response->response;

		$this->setAttribute('success', $dataResponse->success);

		if ($dataResponse->success) {
			$this->setAttribute('upToDate', $dataResponse->up_to_date);
			$this->setAttribute('versionIsListable', $dataResponse->version_is_listable);
			$this->setAttribute('requiredVersion', $dataResponse->required_version);
			$this->setAttribute('message', $dataResponse->message);
		}
	}

	public function isSuccess(): bool {
		return $this->getAttribute('success');
	}

	public function isUpToDate(): bool {
		return $this->getAttribute('upToDate');
	}

	public function isVersionListable(): bool {
		return $this->getAttribute('versionIsListable');
	}

	public function getRequiredVersion(): int {
		return $this->getAttribute('requiredVersion');
	}

	public function getMessage(): string {
		return $this->getAttribute('versionIsListable');
	}

}