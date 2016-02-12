<?php

namespace Sharkodlak\Gettext;

/** Translator base class which can be extended to easily implements short method names.
 */
abstract class TranslatorBase implements ShortMethodsTranslator {
	use ShortMethodsTrait;
}
