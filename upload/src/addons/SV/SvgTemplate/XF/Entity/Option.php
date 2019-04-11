<?php

namespace SV\SvgTemplate\XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * Extends \XF\Entity\Option
 */
class Option extends XFCP_Option
{
    protected function _postSave()
    {
        parent::_postSave();

        if ($this->option_id === 'svSvgTemplateRouterIntegration' && $this->isChanged('option_value'))
        {
            /** @var \XF\Entity\ClassExtension $classExtension */
            $classExtension = \XF::finder('XF:ClassExtension')
                                 ->where('from_class', '=', 'XF\Mvc\Router')
                                 ->where('to_class', '=', 'SV\SvgTemplate\XF\Mvc\Router')
                                 ->fetchOne();
            if ($classExtension)
            {
                $classExtension->active = (bool)$this->option_value;
                $classExtension->saveIfChanged();
            }
        }
    }
}