<?php

class View {
    function getTemplate($template, $params = array()) {
        extract($params);
        ob_start();
        include ROOT."/views/".ucfirst($template)."View.php";
        return ob_get_clean();
    }

    function combineTemplates($template, $params = array()) {
        $content = $this->getTemplate($template, $params);

        return $this->getTemplate("layout", ["content" => $content]);
    }

    function render($template, $params = array()) {
        echo $this->combineTemplates($template, $params);
    }
}