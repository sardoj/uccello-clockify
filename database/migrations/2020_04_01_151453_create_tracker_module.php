<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Uccello\Core\Database\Migrations\Migration;
use Uccello\Core\Models\Module;
use Uccello\Core\Models\Domain;
use Uccello\Core\Models\Tab;
use Uccello\Core\Models\Block;
use Uccello\Core\Models\Field;
use Uccello\Core\Models\Filter;
use Uccello\Core\Models\Relatedlist;
use Uccello\Core\Models\Link;

class CreateTrackerModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createTable();
        $module = $this->createModule();
        $this->activateModuleOnDomains($module);
        $this->createTabsBlocksFields($module);
        $this->createFilters($module);
        $this->createRelatedLists($module);
        $this->createLinks($module);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop table
        Schema::dropIfExists($this->tablePrefix . 'trackers');

        // Delete module
        Module::where('name', 'tracker')->forceDelete();
    }

    protected function initTablePrefix()
    {
        $this->tablePrefix = 'clockify_';

        return $this->tablePrefix;
    }

    protected function createTable()
    {
        Schema::create($this->tablePrefix . 'trackers', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_start');
            $table->time('time_start');
            $table->date('date_end')->nullable();
            $table->time('time_end')->nullable();
            $table->unsignedInteger('project_id')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('domain_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('domain_id')->references('id')->on('uccello_domains');
// %table_foreign_keys%
        });
    }

    protected function createModule()
    {
        $module = Module::create([
            'name' => 'tracker',
            'icon' => 'schedule',
            'model_class' => 'Sardoj\Clockify\Tracker',
            'data' => json_decode('{"package":"sardoj\/clockify"}')
        ]);

        return $module;
    }

    protected function activateModuleOnDomains($module)
    {
        $domains = Domain::all();
        foreach ($domains as $domain) {
            $domain->modules()->attach($module);
        }
    }

    protected function createTabsBlocksFields($module)
    {
        // Tab tab.main
        $tab = Tab::create([
            'module_id' => $module->id,
            'label' => 'tab.main',
            'icon' => null,
            'sequence' => $module->tabs()->count(),
            'data' => null
        ]);

        // Block block.general
        $block = Block::create([
            'module_id' => $module->id,
            'tab_id' => $tab->id,
            'label' => 'block.general',
            'icon' => 'info',
            'sequence' => $tab->blocks()->count(),
            'data' => null
        ]);

        // Field date_start
        Field::create([
            'module_id' => $module->id,
            'block_id' => $block->id,
            'name' => 'date_start',
            'uitype_id' => uitype('date')->id,
            'displaytype_id' => displaytype('everywhere')->id,
            'sequence' => $block->fields()->count(),
            'data' => json_decode('{"rules":"required"}')
        ]);

        // Field time_start
        Field::create([
            'module_id' => $module->id,
            'block_id' => $block->id,
            'name' => 'time_start',
            'uitype_id' => uitype('time')->id,
            'displaytype_id' => displaytype('everywhere')->id,
            'sequence' => $block->fields()->count(),
            'data' => json_decode('{"rules":"required"}')
        ]);

        // Field date_end
        Field::create([
            'module_id' => $module->id,
            'block_id' => $block->id,
            'name' => 'date_end',
            'uitype_id' => uitype('date')->id,
            'displaytype_id' => displaytype('everywhere')->id,
            'sequence' => $block->fields()->count(),
            'data' => null
        ]);

        // Field time_end
        Field::create([
            'module_id' => $module->id,
            'block_id' => $block->id,
            'name' => 'time_end',
            'uitype_id' => uitype('time')->id,
            'displaytype_id' => displaytype('everywhere')->id,
            'sequence' => $block->fields()->count(),
            'data' => null
        ]);

        // Field project
        Field::create([
            'module_id' => $module->id,
            'block_id' => $block->id,
            'name' => 'project',
            'uitype_id' => uitype('entity')->id,
            'displaytype_id' => displaytype('everywhere')->id,
            'sequence' => $block->fields()->count(),
            'data' => json_decode('{"module":"project"}')
        ]);

        // Field description
        Field::create([
            'module_id' => $module->id,
            'block_id' => $block->id,
            'name' => 'description',
            'uitype_id' => uitype('textarea')->id,
            'displaytype_id' => displaytype('everywhere')->id,
            'sequence' => $block->fields()->count(),
            'data' => null
        ]);

    }

    protected function createFilters($module)
    {
        // Filter
        Filter::create([
            'module_id' => $module->id,
            'domain_id' => null,
            'user_id' => null,
            'name' => 'filter.all',
            'type' => 'list',
            'columns' => [ 'date_start', 'time_start', 'date_end', 'time_end', 'project', 'description' ],
            'conditions' => null,
            'order' => null,
            'is_default' => true,
            'is_public' => false,
            'data' => [ 'readonly' => true ]
        ]);

    }

    protected function createRelatedLists($module)
    {
    }

    protected function createLinks($module)
    {
    }
}