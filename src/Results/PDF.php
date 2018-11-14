<?php
namespace Vleks\BolPlazaSDK\Results;

class PDF
{
    protected $contents;

    /**
     * Create a new PDF result
     *
     * @param   string  $contents
     */
    public function __construct($contents)
    {
        $this->contents = $contents;
    }

    /**
     * Get data
     *
     * @return  string
     */
    public function getData()
    {
        return $this->contents;
    }

    /**
     * Display PDF
     */
    public function __toString()
    {
        header('Content-Type: application/pdf');
        echo $this->contents;
    }
}
