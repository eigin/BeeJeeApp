<?php
/**
 *  View class for BeeJeeTest app
 *  @author @eigins
 */

namespace controller;


class View
{

    /**
    * рендер по шаблону
    */
    public function renderTemplate($templateName, $templateData)
    {
        $buffer = null;
        extract($templateData);
        ob_start();
        include (__DIR__ . '/../view/' . $templateName);
        $buffer = ob_get_contents();
        ob_end_clean();
        echo $buffer;
    }

}