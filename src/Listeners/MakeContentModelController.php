<?php

namespace Thtg88\MmCms\Listeners;

use Thtg88\MmCms\Events\ContentModelStored;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MakeContentModelController
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ContentModelStored  $event
     * @return void
     */
    public function handle(ContentModelStored $event)
    {
        $model_name = studly_case($event->content_model->name);
        $controller_name = $model_name.'Controller';

        if(!class_exists($controller_name))
        {
            \Artisan::call('make:controller', [
                'name' => $controller_name,
            ]);

            if(file_exists(app_path('Http/Controllers/'.$controller_name.'.php')))
            {
                $model_content = file_get_contents(app_path('Http/Controllers/'.$controller_name.'.php'));

                if($model_content !== false)
                {
                    $replace_content = $this->getContentModelControllerAdditionalContent($model_name);

                    $model_content = str_replace('//', $replace_content, $model_content);

                    $replace_content = $this->getContentModelControllerImports($model_name);

                    $model_content = str_replace('use Illuminate\Http\Request;', $replace_content, $model_content);

                    file_put_contents(app_path('Http/Controllers/'.$controller_name.'.php'), $model_content);
                }
            }
        }
    }

    /**
     * Returns imports for the controller from a given model name.
     *
     * @param   string  $model_name
     * @return  string
     */
    private function getContentModelControllerImports($model_name)
    {
        $replace_content = '';
        $replace_content .= "// Repositories\n";
        $replace_content .= "use App\Repositories\\".$model_name."Repository;\n";
        $replace_content .= "// Requests\n";
        $replace_content .= "use App\Http\Requests\\".$model_name."\Destroy".$model_name."Request;\n";
        $replace_content .= "use App\Http\Requests\\".$model_name."\Store".$model_name."Request;\n";
        $replace_content .= "use App\Http\Requests\\".$model_name."\Update".$model_name."Request;";

        return $replace_content;
    }

    /**
     * Returns additional content for the controller from a given model name.
     *
     * @param   string  $model_name
     * @return  string
     */
    private function getContentModelControllerAdditionalContent($model_name)
    {
        $replace_content = '';
        $replace_content .= "/**\n";
        $replace_content .= "     * Create a new controller instance.\n";
        $replace_content .= "     *\n";
        $replace_content .= "     * @param       \Thtg88\MmCms\Repositories\\".$model_name."Repository        \$repository\n";
        $replace_content .= "     * @return      void\n";
        $replace_content .= "     */\n";
        $replace_content .= "    public function __construct(".$model_name."Repository \$repository)\n";
        $replace_content .= "    {\n";
        $replace_content .= "        \$this->repository = \$repository;\n";
        $replace_content .= "    }\n";
        $replace_content .= "\n";
        $replace_content .= "    /**\n";
        $replace_content .= "     * Store a newly created resource in storage.\n";
        $replace_content .= "     *\n";
        $replace_content .= "     * @param  \Thtg88\MmCms\Http\Requests\\".$model_name."\Store".$model_name."Request  \$request\n";
        $replace_content .= "     * @return \Illuminate\Http\Response\n";
        $replace_content .= "     */\n";
        $replace_content .= "    public function store(Store".$model_name."Request \$request)\n";
        $replace_content .= "    {\n";
        $replace_content .= "        // Get input\n";
        $replace_content .= "        \$input = \$request->all();\n";
        $replace_content .= "\n";
        $replace_content .= "        // Create\n";
        $replace_content .= "        \$resource = \$this->repository->create(\$input);\n";
        $replace_content .= "\n";
        $replace_content .= "        return response()->json([\n";
        $replace_content .= "            'success' => true,\n";
        $replace_content .= "            'resource' => \$resource,\n";
        $replace_content .= "        ]);\n";
        $replace_content .= "    }\n";
        $replace_content .= "\n";
        $replace_content .= "    /**\n";
        $replace_content .= "     * Update the specified resource in storage.\n";
        $replace_content .= "     *\n";
        $replace_content .= "     * @param  \Thtg88\MmCms\Http\Requests\\".$model_name."\Update".$model_name."Request  \$request\n";
        $replace_content .= "     * @param  int  \$id\n";
        $replace_content .= "     * @return \Illuminate\Http\Response\n";
        $replace_content .= "     */\n";
        $replace_content .= "    public function update(Update".$model_name."Request \$request, \$id)\n";
        $replace_content .= "    {\n";
        $replace_content .= "        // Get input\n";
        $replace_content .= "        \$input = \$request->all();\n";
        $replace_content .= "\n";
        $replace_content .= "        // Update\n";
        $replace_content .= "        \$resource = \$this->repository->update(\$id, \$input);\n";
        $replace_content .= "\n";
        $replace_content .= "        // No need to check if found as done by authorization method\n";
        $replace_content .= "\n";
        $replace_content .= "        return response()->json([\n";
        $replace_content .= "            'success' => true,\n";
        $replace_content .= "            'resource' => \$resource,\n";
        $replace_content .= "        ]);\n";
        $replace_content .= "    }\n";
        $replace_content .= "\n";
        $replace_content .= "    /**\n";
        $replace_content .= "     * Remove the specified resource from storage.\n";
        $replace_content .= "     *\n";
        $replace_content .= "     * @param  \Thtg88\MmCms\Http\Requests\\".$model_name."\Destroy".$model_name."Request  \$request\n";
        $replace_content .= "     * @param  int  \$id\n";
        $replace_content .= "     * @return \Illuminate\Http\Response\n";
        $replace_content .= "     */\n";
        $replace_content .= "    public function destroy(Destroy".$model_name."Request \$request, \$id)\n";
        $replace_content .= "    {\n";
        $replace_content .= "        // Delete resource\n";
        $replace_content .= "        \$resource = \$this->repository->destroy(\$id);\n";
        $replace_content .= "\n";
        $replace_content .= "        return response()->json([\n";
        $replace_content .= "            'success' => true,\n";
        $replace_content .= "            'resource' => \$resource,\n";
        $replace_content .= "        ]);\n";
        $replace_content .= "    }";

        return $replace_content;
    }
}
