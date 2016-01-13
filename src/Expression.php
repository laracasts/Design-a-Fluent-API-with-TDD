<?php

class Expression
{
    /**
     * The generated regular expression.
     */
    protected $expression = '';
    
    /**
     * Make a new instance.
     */
    public static function make()
    {
        return new static;
    }
    
    /**
     * Find a string.
     *
     * @param string $value
     */
    public function find($value)
    {
        return $this->add($this->sanitize($value));
    }
    
    /**
     * Alias for the "find" method.
     *
     * @param string $value
     */
    public function then($value)
    {
        return $this->find($value);
    }
    
    /**
     * Find any number of characters.
     */
    public function anything()
    {
        return $this->add('.*?');
    }
    
    /**
     * Find any number of characters, except the given value.
     *
     * @param string $value
     */
    public function anythingBut($value)
    {
        $value = $this->sanitize($value);

        return $this->add("(?!$value).*?");
    }
    
    /**
     * Optionally find a value.
     *
     * @param string $value
     */
    public function maybe($value)
    {
        $value = $this->sanitize($value);

        return $this->add("(?:$value)?");
    }
    
    /**
     * Append a value to the regular expression.
     *
     * @param string $value
     */
    protected function add($value)
    {
        $this->expression .= $value;

        return $this;
    }
    
    /**
     * Sanitize the given value.
     *
     * @param string $value
     */
    protected function sanitize($value)
    {
        return preg_quote($value, '/');
    }
    
    /**
     * Test the given value against the regex.
     *
     * @param string $value
     */
    public function test($value)
    {
        return (bool) preg_match($this->getRegex(), $value);
    }
    
    /**
     * Fetch the generated regular expression.
     */
    public function getRegex()
    {
        return '/'.$this->expression.'/';
    }
    
    /**
     * Handle when the object is referenced as a string.
     */
    public function __toString()
    {
        return $this->getRegex();
    }
}
