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

class CreateProjectModule extends Migration
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
        Schema::dropIfExists($this->tablePrefix . 'projects');

        // Delete module
        Module::where('name', 'project')->forceDelete();
    }

    protected function initTablePrefix()
    {
        $this->tablePrefix = 'clockify_';

        return $this->tablePrefix;
    }

    protected function createTable()
    {
        Schema::create($this->tablePrefix . 'projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('account_id')->nullable();
            $table->string('color')->nullable();
            $table->boolean('is_public')->nullable();
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
            'name' => 'project',
            'icon' => 'description',
            'model_class' => 'Sardoj\Clockify\Project',
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

        // Field name
        Field::create([
            'module_id' => $module->id,
            'block_id' => $block->id,
            'name' => 'name',
            'uitype_id' => uitype('text')->id,
            'displaytype_id' => displaytype('everywhere')->id,
            'sequence' => $block->fields()->count(),
            'data' => json_decode('{"rules":"required"}')
        ]);

        // Field account
        Field::create([
            'module_id' => $module->id,
            'block_id' => $block->id,
            'name' => 'account',
            'uitype_id' => uitype('entity')->id,
            'displaytype_id' => displaytype('everywhere')->id,
            'sequence' => $block->fields()->count(),
            'data' => json_decode('{"module":"account"}')
        ]);

        // Field color
        Field::create([
            'module_id' => $module->id,
            'block_id' => $block->id,
            'name' => 'color',
            'uitype_id' => uitype('color')->id,
            'displaytype_id' => displaytype('everywhere')->id,
            'sequence' => $block->fields()->count(),
            'data' => null
        ]);

        // Field is_public
        Field::create([
            'module_id' => $module->id,
            'block_id' => $block->id,
            'name' => 'is_public',
            'uitype_id' => uitype('checkbox')->id,
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
            'columns' => [ 'name', 'account', 'color', 'is_public' ],
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