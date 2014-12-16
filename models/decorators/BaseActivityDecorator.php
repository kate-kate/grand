<?php
namespace app\models\decorators;

/**
 * Description of BaseActivityDecorator
 *
 * @author mlapko
 */
abstract class BaseActivityDecorator
{
    protected $attributes;
    protected $changeAttributes;
    
    public function __construct($data)
    {
        $this->attributes = $data['attrs'];
        $this->changeAttributes = $data['changed'];
    }
    
    /**
     * @param \yii\web\View
     */
    abstract function render($view);
}
