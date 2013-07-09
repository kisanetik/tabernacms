<?php
class Smarty_Internal_Compile_Const extends Smarty_Internal_CompileBase 
{
    public function compile($args, $compiler, $parameter)
    {
        if(empty($args) or !isset($args[0]) or strlen($args[0]) < 3 ) {
            throw new rad_exception('Not enouph actual parameters for tag {const');
        }
        return '<?php echo rad_input::getDefine(\''.substr($args[0], 1, -1).'\'); ?>';
    }

}