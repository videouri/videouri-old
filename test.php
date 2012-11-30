<?php
function my_func($variable) {
	if (is_numeric($variable) && ($return = $variable % 2) == 0) { return true; } return false; }

var_dump(my_func(8)); ?>