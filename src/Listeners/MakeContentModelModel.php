<?php

namespace Thtg88\MmCms\Listeners;

use Thtg88\MmCms\Events\ContentModelStored;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MakeContentModelModel
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

        \Artisan::call('make:model', [
            'name' => $model_name,
        ]);

        if(file_exists(app_path($model_name.'.php')))
        {
            $model_content = file_get_contents(app_path($model_name.'.php'));

            if($model_content !== false)
            {
                $replace_content = $this->getContentModelModelAdditionalContent($event->content_model->table_name);

                $model_content = str_replace('//', $replace_content, $model_content);

                file_put_contents(app_path($model_name.'.php'), $model_content);
            }
        }
    }

    /**
     * Returns additional content for the model from a given table name.
     *
     * @param   string  $table_name
     * @return  string
     */
    private function getContentModelModelAdditionalContent($table_name)
    {
        $replace_content = '';
        $replace_content .= "/**\n";
        $replace_content .= "     * The database table used by the model.\n";
        $replace_content .= "     *\n";
        $replace_content .= "     * @var string\n";
        $replace_content .= "     */\n";
        $replace_content .= "    protected \$table = '".$table_name."';\n";
        $replace_content .= "\n";
        $replace_content .= "    /**\n";
        $replace_content .= "     * The primary key for the model.\n";
        $replace_content .= "     *\n";
        $replace_content .= "     * @var string\n";
        $replace_content .= "     */\n";
        $replace_content .= "    protected \$primaryKey = 'id';\n";
        $replace_content .= "\n";
        $replace_content .= "    /**\n";
        $replace_content .= "     * The attributes that are mass assignable.\n";
        $replace_content .= "     *\n";
        $replace_content .= "     * @var array\n";
        $replace_content .= "     */\n";
        $replace_content .= "    protected \$fillable = [\n";
        $replace_content .= "        'created_at',\n";
        $replace_content .= "        // fillable attributes\n";
        $replace_content .= "    ];\n";
        $replace_content .= "\n";
        $replace_content .= "    /**\n";
        $replace_content .= "     * The attributes that should be visible in arrays.\n";
        $replace_content .= "     *\n";
        $replace_content .= "     * @var array\n";
        $replace_content .= "     */\n";
        $replace_content .= "    protected \$visible = [\n";
        $replace_content .= "        'created_at',\n";
        $replace_content .= "        'id',\n";
        $replace_content .= "        // visible attributes\n";
        $replace_content .= "    ];\n";
        $replace_content .= "\n";
        $replace_content .= "    /**\n";
        $replace_content .= "     * The relations to eager load on every query.\n";
        $replace_content .= "     *\n";
        $replace_content .= "     * @var array\n";
        $replace_content .= "     */\n";
        $replace_content .= "    protected \$visible = [\n";
        $replace_content .= "        // with attributes\n";
        $replace_content .= "    ];\n";
        $replace_content .= "\n";
        $replace_content .= "    // RELATIONSHIPS\n";

        return $replace_content;
    }
}
