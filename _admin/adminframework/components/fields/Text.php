<?php

/*
 * This file is part of the Natty CMS (http://nattycms.org), based on the Nette Framework (http://nette.org)
 *  Copyright (c) 2013 Daniel Sýkora (http://danielsykora.com)
 */

namespace Natty\AdminFramework\Fields;

/**
 * Description of TextField
 *
 * @author Daniel Sýkora <jsem@danielsykora.com>
 */
class Text extends Field {
    public $useInGrid = true;
    public $filter = true;
    public $sortable = true;
    public $maxLength;
    protected $formFunctionName = "addText";


    /**
     * max length for form restriction
     * @param int $len
     * @return Provides fluent interface
     */
    public function setMaxLength($len) {
	$this->maxLength = $len;
	return $this;
    }

    public function getMaxLength() {
	return $this->maxLength;
    }

}

