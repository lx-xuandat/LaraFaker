<?php

namespace App\Cores;

use Illuminate\Database\Capsule\Manager as Capsule;

class Migrate
{
    public function __construct()
    {
        $this->createTableMigrates();
    }

    protected function createTableMigrates(): Migrate
    {
        if (!Capsule::schema()->hasTable('tbl_migrations')) {
            Capsule::schema()->create('tbl_migrations', function ($table) {
                $table->increments('id');
                $table->string('migration');
            });
        }

        return $this;
    }

    public function apply()
    {
        try {
            $migrationsInTable = $this->getMigrationInTable();
            $migrationsInFolder = $this->getMigrationInFolder();

            $diffValues = array_diff($migrationsInFolder, $migrationsInTable);
            foreach ($diffValues as $key => $file) {
                require ROOT . '/database/migrations/' . $file . '.php';
                Capsule::table('tbl_migrations')->insert([
                    'migration' => $file
                ]);
            }

        } catch (\Throwable $th) {
            echo "Stack trace:\n $file\n\n";

            echo $th->getMessage();
        }
    }

    public function getMigrationInTable(): array
    {
        return Capsule::table('tbl_migrations')->pluck('migration')->toArray();
    }

    public function getMigrationInFolder(): array
    {
        $files = [];

        foreach (glob(ROOT . '/database/migrations/*.php') as $file) {
            $files[] = pathinfo($file)['filename'];
        }

        return $files;
    }
}
