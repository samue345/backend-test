<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;



class CreateRedirectTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_invalid_dns()
    {
        $response = $this->post(route('redirects.store'), [
            'url_destino' => 'https://ettetdgfcgfdgdghsggdgdggdgdgdgdgdgdg.com?marcola=jhhdhsdhj',
        ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['url_destino' => 'DNS inválido.']);
    }

    public function test_error_url()
    {
       
    
        $response = $this->post(route('redirects.store'), [
            '_token' => csrf_token(),
            'url_redirect' => 'https:/marcola',

        ]);
    
        $response->assertStatus(302)
            ->assertSessionHasErrors(['url_destino' => 'O campo URL de destino é obrigatório.']);
    }
    public function test_url_pointer_app()
    {
       
       $response = $this->post(route('redirects.store'), [
            'url_destino' => config('app.url') . '/marcola/47',
        ]);
    
        $response->assertStatus(302)
            ->assertSessionHasErrors(['url_destino' => 'A url não pode apontar pra própria aplicação.']);

    }
    public function test_url_without_https()
    {
       
    
        $response = $this->post(route('redirects.store'), [
            'url_destino' => 'http://fakeurl.com',
        ]);
    
        $response->assertStatus(302)
            ->assertSessionHasErrors(['url_destino' => 'A url tem que começar com https']);

    }
   
}