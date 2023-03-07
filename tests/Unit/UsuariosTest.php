<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UsuariosTest extends TestCase
{
    use DatabaseMigrations; // para crear la base de datos de prueba en cada test
    use WithoutMiddleware; // para eludir la autenticación en cada test
    use DatabaseTransactions; // para realizar las pruebas de la base de datos en transacciones

    /**
     * @test
     */
    public function mostrar_usuarios()
    {
        // crear un usuario de prueba en la base de datos
        $user = factory(App\User::class)->create();

        // visitar la página de usuarios y comprobar el código de respuesta
        $response = $this->call('GET', '/usuarios');
        $this->assertEquals(200, $response->status());

        // buscar el usuario en la página y comprobar que se muestra correctamente
        $this->see($user->nombre);
        $this->see($user->email);
    }

    /**
     * @test
     */
    public function crear_usuario()
    {
        // enviar un formulario de creación de usuario con datos válidos
        $this->visit('/usuarios/nuevo')
             ->type('John Doe', 'nombre')
             ->type('john.doe@example.com', 'email')
             ->type('password', 'password')
             ->select('1', 'admin')
             ->press('Crear')
             ->see('El usuario ha sido creado.');

        // buscar el usuario en la base de datos y comprobar que se ha creado correctamente
        $this->seeInDatabase('users', [
            'nombre' => 'John Doe',
            'email' => 'john.doe@example.com',
            'admin' => '1'
        ]);
    }

    /**
     * @test
     */
    public function editar_usuario()
    {
        // crear un usuario de prueba en la base de datos
        $user = factory(App\User::class)->create([
            'nombre' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => bcrypt('password'),
            'admin' => '1'
        ]);

        // enviar un formulario de edición de usuario con datos válidos
        $this->visit('/usuarios/'.$user->id.'/editar')
             ->type('Jane Doe', 'nombre')
             ->type('jane.doe@example.com', 'email')
             ->type('newpassword', 'password')
             ->select('0', 'admin')
             ->press('Guardar')
             ->see('El usuario ha sido actualizado.');

        // buscar el usuario en la base de datos y comprobar que se ha editado correctamente
        $this->seeInDatabase('users', [
            'id' => $user->id,
            'nombre' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'admin' => '0'
        ]);
    }

    /**
     * @test
     */
    public function eliminar_usuario()
    {
        // crear un usuario de prueba en la base de datos
        $user = factory(App\User::class)->create();

        // enviar una solicitud de eliminación de usuario
        $this->visit('/usuarios/'.$user->id.'/eliminar')
             ->see('¿Está seguro de que desea eliminar el usuario?')
             ->press('Sí')
             ->see('El usuario ha sido eliminado.');

        // buscar el usuario en la base de datos y comprobar que se ha eliminado correctamente
        $this->notSeeInDatabase('users', ['id' => $user->id]);
    }
}