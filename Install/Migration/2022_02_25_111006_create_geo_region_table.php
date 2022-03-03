<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateGeoRegionTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //允许更新表内容，先删除重新创建
        Schema::dropIfExists('geo_region');
        Schema::create('geo_region', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('code')
                ->nullable(false)
                ->default(0)
                ->comment('行政代码');
            $table->integer('p_code')
                ->nullable(false)
                ->default(0)
                ->comment('上级行政代码');
            $table->string('region_name', 256)
                ->default('')
                ->nullable(false)
                ->comment('行政区域名称');
            $table->integer('level')
                ->nullable(false)
                ->default(0)
                ->comment('区域等级');
        });
        //写入数据库
        $lists = json_decode(file_get_contents(__DIR__ . '/data/pca-code.json'), true);
        $this->makeRegion($lists);
    }

    private function makeRegion($lists, int $level = 1, int $p_code = 0)
    {
        foreach ($lists as $item) {
            $code = $item['code'] ?? 0;
            \Hyperf\DbConnection\Db::table('geo_region')
                ->insertGetId([
                    'code' => $code,
                    'p_code' => $p_code,
                    'region_name' => $item['name'] ?? 0,
                    'level' => $level
                ]);
            $children = $item['children'] ?? [];
            if (!empty($children) && $code) {
                $this->makeRegion($children, $level + 1, $code);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geo_region');
    }
}
