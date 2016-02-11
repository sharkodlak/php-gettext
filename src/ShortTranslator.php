<?php

namespace Sharkodlak\Gettext;

interface ShortTranslator extends ITranslator {
	public function _($message);
	public function d_($domain, $message);
	public function dn_($domain, $singular, $plural, $count);
	public function dnp_($domain, $context, $singular, $plural, $count);
	public function dp_($domain, $context, $message);
	public function n_($singular, $plural, $count);
	public function np_($context, $singular, $plural, $count);
	public function p_($context, $message);
}
