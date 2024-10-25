<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Definir permisos para cada modelo (CRUD)
        // $models = ['Alert', 'Project', 'Register', 'Sensor', 'SensorType',
        $models = ['Client', 'User'];

        foreach ($models as $model) {
            Permission::firstOrCreate(['name' => "create-$model"]);  // Crear
            Permission::firstOrCreate(['name' => "read-$model"]);    // Leer (index y show)
            Permission::firstOrCreate(['name' => "update-$model"]);  // Actualizar
            Permission::firstOrCreate(['name' => "delete-$model"]);  // Eliminar
        }

        // Crear roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // Asignar todos los permisos al rol admin
        $admin->givePermissionTo(Permission::all());

        // Asignar permisos de solo lectura a 'user' (excepto 'User')
        foreach ($models as $model) {
            if ($model !== 'User') { // Suponiendo que los usuarios regulares no gestionan otros usuarios
                $user->givePermissionTo("read-$model");
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Eliminar roles
        Role::where('name', 'admin')->first()->delete();
        Role::where('name', 'user')->first()->delete();

        // Eliminar permisos
        $models = ['Alerta', 'Empresa', 'Proyecto', 'Registro', 'Sensor', 'TipoSensor', 'User'];
        foreach ($models as $model) {
            Permission::where('name', "create-$model")->delete();
            Permission::where('name', "read-$model")->delete();
            Permission::where('name', "update-$model")->delete();
            Permission::where('name', "delete-$model")->delete();
        }
    }
}
