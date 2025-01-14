<?php

namespace App\Libraries;

abstract class BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $type = '';
    protected string $rules = '';
    protected string $default = '';
    protected string $value = '';

    public function __construct(array $attributes)
    {
        // Assign properti dari array ke atribut masing-masing
        foreach ($attributes as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    // Getter untuk mendapatkan semua properti sebagai array
    public function getAttributes(): array
    {
        return get_object_vars($this);
    }

    /**
     * Render field form untuk input.
     */
    public function renderInput(?string $value = null): string
    {
        $classPath = (new \ReflectionClass($this))->getFileName();
        $viewPath = dirname($classPath) . DIRECTORY_SEPARATOR . 'input.php';

        if (!file_exists($viewPath)) {
            throw new \Exception("Input view file not found for field: " . $this->name);
        }

        ob_start();
        extract([
            'config' => $this->getAttributes(), 
            'value' => $value ?? $this->default
        ]);
        include $viewPath;
        return ob_get_clean();
    }

    /**
     * Render field value untuk output.
     */
    public function renderOutput(?string $value): string
    {
        $classPath = (new \ReflectionClass($this))->getFileName();
        $viewPath = dirname($classPath) . DIRECTORY_SEPARATOR . 'output.php';

        if (!file_exists($viewPath)) {
            throw new \Exception("Output view file not found for field: " . $this->name);
        }

        ob_start();
        extract(['value' => $value ?? $this->default] + $this->getAttributes());
        include $viewPath;
        return ob_get_clean();
    }
}
