<?php

/**
Copyright (c) 2016 dog-ears

This software is released under the MIT License.
http://dog-ears.net/
*/

namespace dogears\L5scaffold\Makes;

use Illuminate\Filesystem\Filesystem;
use dogears\L5scaffold\Commands\ScaffoldMakeCommand;
use dogears\L5scaffold\Stubs\StubController;
use dogears\L5scaffold\Traits\MakerTrait;
use dogears\L5scaffold\Traits\NameSolverTrait;
use dogears\L5scaffold\Traits\OutputTrait;

class MakeModel {
    use MakerTrait,NameSolverTrait,OutputTrait;

    protected $files;
    protected $commandObj;

    public function __construct($command, Filesystem $files)
    {
        $this->files = $files;
        $this->commandObj = $command;
        $this->start();
    }

    protected function start()
    {
        //get_stub_path and filename
        $stub_path = __DIR__.'/../Stubs/model/';
        $stub_filename = 'app.stub';

        //create new stub
        $stub = new StubController( $this->commandObj, $this->files, $stub_path.$stub_filename, $schema_repalce_type = 'model', $custom_replace = null );

        //compile
        $stub_compiled = $stub->getCompiled();

        //get output_path and filename
        $output_path = './app/';
        $output_filename = $this->solveName($this->commandObj->argument('name'), config('l5scaffold.app_name_rules.app_model_class')).'.php';

        //output(use OutputTrait)
        $this->outputPut( $output_path, $output_filename, $stub_compiled, $debug=false );
    }
}
