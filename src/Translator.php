<?php

namespace Sharkodlak\Gettext;

class Translator extends ATranslator {
	private $aliases = [];
	private $domains = [];

	public function __construct($dir, $domain = 'default', $codeset = 'UTF-8') {
		$this->setDomain($dir, $domain, $codeset);
		textdomain($domain);
	}

	final public function setDomain($dir, $domain, $codeset = 'UTF-8') {
		bindtextdomain($domain, $dir);
		bind_textdomain_codeset($domain, $codeset);
		$this->domains[$domain] = $domain;
		return $this;
	}

	public function setDomainWithAlias($alias, $dir, $domain, $codeset = 'UTF-8') {
		$this->setDomain($dir, $domain, $codeset = 'UTF-8');
		$this->aliases[$alias] = $domain;
		return $this;
	}

	public function dgettext($domain, $message) {
		$domain = $this->getDomain($domain);
		return dgettext($domain, $message);
	}

	public function dngettext($domain, $singular, $plural, $count) {
		$domain = $this->getDomain($domain);
		return dngettext($domain, $singular, $plural, $count);
	}

	public function dnpgettext($domain, $context, $singular, $plural, $count) {
		$domain = $this->getDomain($domain);
		return dnpgettext($domain, $context, $singular, $plural, $count);
	}

	public function dpgettext($domain, $context, $message) {
		$domain = $this->getDomain($domain);
		return dpgettext($domain, $context, $message);
	}

	public function getDomain($alias) {
		$domain = $alias;
		if (isset($this->aliases[$alias])) {
			$domain = $this->aliases[$alias];
		}
		return $domain;
	}

	public function gettext($message) {
		return gettext($message);
	}

	public function ngettext($singular, $plural, $count) {
		return ngettext($singular, $plural, $count);
	}

	public function npgettext($context, $singular, $plural, $count) {
		return npgettext($context, $singular, $plural, $count);
	}

	public function pgettext($context, $message) {
		return pgettext($context, $message);
	}
}
