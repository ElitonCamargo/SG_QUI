<?php
function analisarFormulaQuimica($formula) {
    $composicao = [];
    preg_match_all('/([A-Z][a-z]*)(\d*)/', $formula, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
        $elemento = $match[1];
        $quantidade = empty($match[2]) ? 1 : intval($match[2]); 
        $composicao[$elemento] = $quantidade;
    }
    return $composicao;
}