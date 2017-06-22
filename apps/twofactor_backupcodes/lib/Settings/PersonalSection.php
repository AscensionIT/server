<?php
/**
 * @copyright Copyright (c) 2017 Arthur Schiwon <blizzz@arthur-schiwon.de>
 *
 * @author Arthur Schiwon <blizzz@arthur-schiwon.de>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\TwoFactorBackupCodes\Settings;


use OCA\TwoFactorBackupCodes\Provider\BackupCodesProvider;
use OCP\IL10N;
use OCP\IURLGenerator;
use OCP\IUserSession;
use OCP\Settings\IIconSection;

class PersonalSection implements IIconSection {

	/** @var IURLGenerator */
	private $urlGenerator;
	/** @var IL10N */
	private $l;
	/** @var BackupCodesProvider */
	private $provider;
	/** @var IUserSession */
	private $userSession;

	public function __construct(IURLGenerator $urlGenerator, IL10N $l, BackupCodesProvider $provider, IUserSession $userSession) {
		$this->urlGenerator = $urlGenerator;
		$this->l = $l;
		$this->provider = $provider;
		$this->userSession = $userSession;
	}

	/**
	 * returns the relative path to an 16*16 icon describing the section.
	 * e.g. '/core/img/places/files.svg'
	 *
	 * @returns string
	 * @since 12
	 */
	public function getIcon() {
		return $this->urlGenerator->imagePath('settings', 'password.svg');
	}

	/**
	 * returns the ID of the section. It is supposed to be a lower case string,
	 * e.g. 'ldap'
	 *
	 * @returns string
	 * @since 9.1
	 */
	public function getID() {
		if (!$this->provider->isActive($this->userSession->getUser())) {
			return null;
		}
		return 'twofactor';
	}

	/**
	 * returns the translated name as it should be displayed, e.g. 'LDAP / AD
	 * integration'. Use the L10N service to translate it.
	 *
	 * @return string
	 * @since 9.1
	 */
	public function getName() {
		return $this->l->t('Second factor auth');
	}

	/**
	 * @return int whether the form should be rather on the top or bottom of
	 * the settings navigation. The sections are arranged in ascending order of
	 * the priority values. It is required to return a value between 0 and 99.
	 *
	 * E.g.: 70
	 * @since 9.1
	 */
	public function getPriority() {
		return 8;
	}
}
