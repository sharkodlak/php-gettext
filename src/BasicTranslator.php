<?php

namespace Sharkodlak\Gettext;

/** Basic implementation.
 */
class BasicTranslator extends TranslatorBase {
	use ExpandMethodsTrait;

	private $aliases = [];
	private $domains = [];

	/** Create instance and set default domain.
	 *
	 * @param string  $dir Directory path, where to find domain. In this directory current locale named subdirectory will be searched.
	 * @param string  $domain Domain name - filename without MO extension.
	 * @param string  $codeset Domain file codeset.
	 */
	public function __construct($dir, $domain = 'default', $codeset = 'UTF-8') {
		$this->setDomain($dir, $domain, $codeset);
		textdomain($domain);
	}

	/** Set domain name.
	 *
	 * @param string  $dir Directory path, where to find domain. In this directory current locale named subdirectory will be searched.
	 * @param string  $domain Domain name - filename without MO extension.
	 * @param string  $codeset Domain file codeset.
	 *
	 * @return $this
	 */
	final public function setDomain($dir, $domain, $codeset = 'UTF-8') {
		bindtextdomain($domain, $dir);
		bind_textdomain_codeset($domain, $codeset);
		$this->domains[] = $domain;
		return $this;
	}

	/** Set domain name with it's alias.
	 *
	 * @param string  $alias Domain name alias, useful for easier domain usage.
	 * @param string  $dir Directory path, where to find domain. In this directory current locale named subdirectory will be searched.
	 * @param string  $domain Domain name - filename without MO extension.
	 * @param string  $codeset Domain file codeset.
	 *
	 * @return $this
	 */
	public function setDomainWithAlias($alias, $dir, $domain, $codeset = 'UTF-8') {
		$this->setDomain($dir, $domain, $codeset);
		$this->aliases[$alias] = $domain;
		return $this;
	}

	public function dgettext($domain, $message) {
		$domain = $this->getDomain($domain);
		return dgettext($domain, $message);
	}

	public function dngettext($domain, $singular, $plural, $count) {
		$domain = $this->getDomain($domain);
		return dngettext($domain, $singular, $plural, abs($count));
	}

	public function dnpgettext($domain, $context, $singular, $plural, $count) {
		$domain = $this->getDomain($domain);
		return dnpgettext($domain, $context, $singular, $plural, abs($count));
	}

	public function dpgettext($domain, $context, $message) {
		$domain = $this->getDomain($domain);
		return dpgettext($domain, $context, $message);
	}

	/** Provide domain name by it's alias.
	 *
	 * @param string  $alias Domain name alias, useful for easier domain usage.
	 *
	 * @return string  Returns associated domain if exists, otherwise it returns unchanged $alias.
	 */
	public function getDomain($alias) {
		if (isset($this->aliases[$alias])) {
			return $this->aliases[$alias];
		}
		return $alias;
	}

	public function getDefaultDomain() {
		return $this->domains[0];
	}
}
