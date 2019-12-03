<?php
namespace\Pxp\DynamicElement;

/**
 * Class Condition
 *
 * Used to determine whether innerHTML is omitted from rendered output
 *
 * <condition toggle="signed_in">
 * <p>Welcome Member</p>
 * </condition>
*/
class Condition extends DynamicElement
{

    /**
     * Renders output if condition toggle is true
     *
     * @return string
     */
    public function onRender(): string
    {
        $variable['signed_in'] = TRUE;

        // if no toggle set return empty
        if (!isset($this->args['@attributes']['toggle'])) {
            return '';
        }

        // get name of condition toggle variable
        $toggle_name = $this->args['@attributes']['toggle'];

        // check if variable set in processor
        if (!isset($variable[$toggle_name])) {
            return '';
        }

        // return inner content
        if ($variable[$toggle_name] == TRUE) {
            return $this->element;
        }

        return '';
    }
}
