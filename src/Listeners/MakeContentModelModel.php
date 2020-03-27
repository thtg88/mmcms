<?php

namespace Thtg88\MmCms\Listeners;

use Illuminate\Support\Str;
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
     * @param ContentModelStored $event
     * @return void
     */
    public function handle(ContentModelStored $event)
    {
        $model_name = Str::studly($event->content_model->name);

        \Artisan::call('make:model', [
            'name' => $model_name,
        ]);

        if (file_exists(app_path($model_name.'.php'))) {
            $file_content = file_get_contents(app_path($model_name.'.php'));

            if ($file_content !== false) {
                $replace_content = $this->getContentModelModelAdditionalContent($event->content_model->table_name);

                $file_content = str_replace('//', $replace_content, $file_content);

                file_put_contents(app_path($model_name.'.php'), $file_content);
            }
        }
    }

    /**
     * Returns additional content for the model from a given table name.
     *
     * @param string $table_name
     * @return string
     */
    private function getContentModelModelAdditionalContent($table_name)
    {
        $content = '';
        $content .= "/**\n";
        $content .= "     * The database table used by the model.\n";
        $content .= "     *\n";
        $content .= "     * @var string\n";
        $content .= "     */\n";
        $content .= "    protected \$table = '".$table_name."';\n";
        $content .= "\n";
        $content .= "    /**\n";
        $content .= "     * The primary key for the model.\n";
        $content .= "     *\n";
        $content .= "     * @var string\n";
        $content .= "     */\n";
        $content .= "    protected \$primaryKey = 'id';\n";
        $content .= "\n";
        $content .= "    /**\n";
        $content .= "     * The attributes that are mass assignable.\n";
        $content .= "     *\n";
        $content .= "     * @var array\n";
        $content .= "     */\n";
        $content .= "    protected \$fillable = [\n";
        $content .= "        'created_at',\n";
        $content .= "        // fillable attributes\n";
        $content .= "    ];\n";
        $content .= "\n";
        $content .= "    /**\n";
        $content .= "     * The attributes that should be visible in arrays.\n";
        $content .= "     *\n";
        $content .= "     * @var array\n";
        $content .= "     */\n";
        $content .= "    protected \$visible = [\n";
        $content .= "        'created_at',\n";
        $content .= "        'id',\n";
        $content .= "        // visible attributes\n";
        $content .= "    ];\n";
        $content .= "\n";
        $content .= "    /**\n";
        $content .= "     * The relations to eager load on every query.\n";
        $content .= "     *\n";
        $content .= "     * @var array\n";
        $content .= "     */\n";
        $content .= "    protected \$visible = [\n";
        $content .= "        // with attributes\n";
        $content .= "    ];\n";
        $content .= "\n";
        $content .= "    // RELATIONSHIPS\n";

        return $content;
    }
}
