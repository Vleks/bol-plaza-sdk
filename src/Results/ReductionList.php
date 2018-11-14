<?php
namespace Vleks\BolPlazaSDK\Results;

class ReductionList
{
    protected $data;
    protected $filename;

    /**
     * Create a new Reduction list result
     *
     * @param   string  $data
     * @param   string  $filename
     */
    public function __construct($data, $filename)
    {
        $this->data     = $data;
        $this->filename = $filename;
    }

    /**
     * Get data
     *
     * @return  string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get filename
     *
     * @return  string
     */
    public function getFilename()
    {
        return $this->filename;
    }
}
