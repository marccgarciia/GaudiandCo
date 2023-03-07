<?php

use PHPUnit\Framework\TestCase;

class UsuarioTest extends TestCase
{
    public function testCrear()
    {
        $this->assertSame(
            "<form><h1>CREAR USUARIO</h1><h3>Nombre</h3><input type=\"text\" required=\"\"><br><h3>Email</h3><input type=\"email\" required=\"\"><br><h3>Password</h3><input id=\"pass\" type=\"text\" required=\"\"><br><h3>Admin</h3><input type=\"number\" required=\"\"><br><button type=\"submit\">Crear</button></form>",
            crear()
        );
    }

    public function testGetUsers()
    {
        $response = getUsers();
        $this->assertTrue(is_array($response));
        $this->assertArrayHasKey('id', $response[0]);
        $this->assertArrayHasKey('nombre', $response[0]);
        $this->assertArrayHasKey('email', $response[0]);
        $this->assertArrayHasKey('password', $response[0]);
        $this->assertArrayHasKey('admin', $response[0]);
    }

    public function testEditar()
    {
        $id = 1;
        $response = editar($id);
        $this->assertSame(
            "<form><h1>MODIFICAR USUARIO</h1><h3>ID</h3><input type=\"num\" value=\"1\" readonly required=\"\"> <br><h3>Nombre</h3><input type=\"text\" value=\"\" required=\"\"><br><h3>Email</h3><input type=\"email\" value=\"\" required=\"\"><br><h3>Password</h3><input id=\"pass\" type=\"text\" value=\"\" required=\"\"><br><h3>Admin</h3><input type=\"number\" value=\"\" required=\"\"><br><button onclick=\"mod(1)\">Modificar</button></form>",
            $response
        );
    }
}
?>