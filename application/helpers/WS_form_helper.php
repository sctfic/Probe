<?php

// ------------------------------------------------------------------------

/**
 * Text Input Field
 *
 * @access  public
 * @param   mixed
 * @param   string
 * @param   string
 * @return  string
 */
if ( ! function_exists('form_label_input'))
{
    function form_label_input($name, $labelData, $inputData)
    {
        $defaults = array('type' => 'text', 'name' => (( ! is_array($data)) ? $data : ''), 'value' => $value);

        return form_label($labelData, $name).form_input($name, $inputData);
    }
}