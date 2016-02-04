<?php

namespace Sharkodlak\Gettext;


abstract class ATranslator implements ITranslator {
	public function _($message) {
		return $this->gettext($message);
	}

	public function d_($domain, $message) {
		return $this->dgettext($domain, $message);
	}

	public function dn_($domain, $singular, $plural, $count) {
		return $this->dngettext($domain, $singular, $plural, $count);
	}

	public function dnp_($domain, $context, $singular, $plural, $count) {
		return $this->dnpgettext($domain, $context, $singular, $plural, $count);
	}

	public function dp_($domain, $context, $message) {
		return $this->dpgettext($domain, $context, $message);
	}

	public function n_($singular, $plural, $count) {
		return $this->ngettext($singular, $plural, $count);
	}

	public function np_($context, $singular, $plural, $count) {
		return $this->npgettext($context, $singular, $plural, $count);
	}

	public function p_($context, $message) {
		return $this->pgettext($context, $message);
	}
}
